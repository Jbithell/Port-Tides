import { TidesJson_TopLevel } from "@/types";
import { TidalGraphComponent } from "./TidalGraphComponent";

export function TidalGraph({ tidalData, date }: { tidalData: TidesJson_TopLevel; date: Date }) {
  const startTimestamp = date;
  startTimestamp.setHours(0, 0, 0, 0);
  const endTimestamp = new Date(startTimestamp);
  endTimestamp.setDate(endTimestamp.getDate() + 1); // The charts don't work so well beyond a day
  let startIndex = tidalData.schedule.findIndex(
    (date) => {
      return new Date(date.date) >= startTimestamp;
    }
  );
  let endIndex = tidalData.schedule.findIndex(
    (date) => {
      return new Date(date.date) >= endTimestamp;
    }
  );

  // Adjust indices to include the days immediately before and after the range to capture them in the graph
  startIndex = startIndex > 0 ? startIndex - 1 : startIndex;
  endIndex = endIndex < tidalData.schedule.length ? endIndex + 1 : endIndex;

  // Slice the array to get the desired elements
  const highTides = tidalData.schedule
    .slice(startIndex, endIndex)
    .flatMap((date) =>
      date.groups.map((tide) => ({
        timestamp: new Date(date.date + " " + tide.time).getTime() / 1000,
        height: Number(tide.height),
      }))
    );

  return (
    <TidalGraphComponent
      highTides={highTides}
      startTimestamp={startTimestamp.getTime() / 1000}
      endTimestamp={endTimestamp.getTime() / 1000}
    />
  );
}
