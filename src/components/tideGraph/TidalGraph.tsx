import { Loader } from "@mantine/core";
import { ClientOnly } from "@tanstack/react-router";
import { graphDataGenerator } from "./graphDataGenerator";
import { TidalGraphComponent } from "./TidalGraphComponent";

export function TidalGraph({
  highTides,
  sunrise,
  sunset,
  startTimestamp,
  endTimestamp,
}: {
  highTides: Array<{ timestamp: number; height: number }>;
  sunrise: number;
  sunset: number;
  startTimestamp: number;
  endTimestamp: number;
}) {
  const graphData = graphDataGenerator(highTides);
  return (
    <ClientOnly fallback={<Loader />}><TidalGraphComponent graphData={graphData} highTides={highTides} sunrise={sunrise} sunset={sunset} startTimestamp={startTimestamp} endTimestamp={endTimestamp} /></ClientOnly>
  );
}
