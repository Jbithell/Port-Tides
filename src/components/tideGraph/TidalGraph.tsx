import React from "react";
import { TidesJson_ScheduleObject } from "../../types";
import TidalData from "../../../data/tides.json";
import { TidalGraphComponent } from "./TidalGraphComponent";

export function TidalGraph({ date }: { date: number }) {
  const startTimestamp = new Date();
  startTimestamp.setHours(0, 0, 0, 0);
  const endTimestamp = new Date(startTimestamp);
  endTimestamp.setDate(endTimestamp.getDate() + 1); // The charts don't work so well beyond a day
  let startIndex = TidalData.schedule.findIndex(
    (date: TidesJson_ScheduleObject) => {
      return new Date(date.date) >= startTimestamp;
    }
  );
  let endIndex = TidalData.schedule.findIndex(
    (date: TidesJson_ScheduleObject) => {
      return new Date(date.date) >= endTimestamp;
    }
  );

  // Adjust indices to include the days immediately before and after the range to capture them in the graph
  startIndex = startIndex > 0 ? startIndex - 1 : startIndex;
  endIndex = endIndex < TidalData.schedule.length ? endIndex + 1 : endIndex;

  // Slice the array to get the desired elements
  const highTides = TidalData.schedule
    .slice(startIndex, endIndex)
    .flatMap((date: TidesJson_ScheduleObject) =>
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
