/**
 * Calculates a tidal curve for a given location
 * According to "TIME & HEIGHT DIFFERENCES FOR PREDICTING THE TIDE AT SECONDARY PORTS" (https://assets.admiralty.co.uk/public/2022-04/5609%202022%20Feb.pdf)
 * For Milford Haven:
 * MHWS  7.0
 * MHWN  5.2
 * MLWN  2.5
 * MLWS  0.7
 * Midpoint therefore 3.85 (calculated as average of MHWS-((MHWS-MLWS)/2) & MHWN-((MHWN-MLWN)/2) )
 *
 * For Criccieth:
 * MHWS  -2   5.0
 * MHWN  -1.8 3.4
 * MLWN  -0.7 1.8
 * MLWS  -0.3 0.4
 * Midpoint therefore = 2.65
 *
 * For Porthmadog:
 * MHWS  -1.9 5.1
 * MHWN  -1.8 3.4
 * MLWN  ??? so we assume 1.8
 * MLWS  ??? so we assume 0.3
 * Midpoint therefore assumed = 2.65
 *
 * Using the midpoint we can derive the lowest height for a given time and high tide to be MIDPOINT - (HEIGHT - MIDPOINT)
 *
 * This isn't very acurate because of the river Glaslyn, so the admiralty do not therefore publish tidal curves for this location, or low tide times - we have just derived them from their data
 *
 */
const MIDPOINT = 2.65;
// According to "TIME & HEIGHT DIFFERENCES FOR PREDICTING THE TIDE AT SECONDARY PORTS"
export const graphDataGenerator = (
  highTides: Array<{ timestamp: number; height: number }>
): Array<{ date: number; Height: number }> => {
  const highAndLowTides = [];
  for (let i = 0; i < highTides.length; i++) {
    highAndLowTides.push({
      ...highTides[i],
      type: "high",
    });
    if (i < highTides.length - 1) {
      // Add low tide
      highAndLowTides.push({
        timestamp:
          highTides[i].timestamp +
          (highTides[i + 1].timestamp - highTides[i].timestamp) / 2,
        height: (MIDPOINT - (highTides[i].height - MIDPOINT)).toFixed(3),
      });
    }
  }
  const plotPoints = [];
  for (let i = 0; i < highAndLowTides.length; i++) {
    plotPoints.push({
      date: highAndLowTides[i].timestamp,
      Height: Number(highAndLowTides[i].height),
    });
    if (i < highAndLowTides.length - 1) {
      let heightDifferenceToNextTide =
        Number(highAndLowTides[i + 1].height) -
        Number(highAndLowTides[i].height);
      let timeDifferenceToNextTide =
        highAndLowTides[i + 1].timestamp - highAndLowTides[i].timestamp;
      for (
        let t = highAndLowTides[i].timestamp;
        t < highAndLowTides[i + 1].timestamp;
        t += 60 //Data point every minute
      ) {
        /**
         * In a cycle from high tide to low tide, the high tide is 1/2π and the low tide is 3/2π
         */
        let sinePoint =
          ((highAndLowTides[i + 1].timestamp - t) / timeDifferenceToNextTide) *
            Math.PI +
          Math.PI / 2;
        let derivedHeight = Number(
          (
            heightDifferenceToNextTide * 0.5 * Math.sin(sinePoint) +
            Number(
              highAndLowTides[i].type === "high" // If next tide is low, then use that height, otherwise use the current heigh
                ? highAndLowTides[i + 1].height
                : highAndLowTides[i].height
            ) +
            // Add back in half the height difference - but only as a positive value
            Math.abs(heightDifferenceToNextTide) / 2
          ).toFixed(3)
        );
        plotPoints.push({
          date: t,
          Height: derivedHeight,
        });
      }
    }
  }
  return plotPoints;
};
