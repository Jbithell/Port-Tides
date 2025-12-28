import { createServerFn } from '@tanstack/react-start';
//import { readFileSync } from "node:fs";
import { notFound } from '@tanstack/react-router';
import { DateTime } from "luxon";
import tidalDataFromFile from '../data/tides.json';
import type { TidesJson_TopLevel } from './types';

//const TIDES_FILE = 'data/tides.json'

const TidalData = () => {
  //const tides = readFileSync(TIDES_FILE, "utf8");
  //return JSON.parse(tides) as TidesJson_TopLevel
  return tidalDataFromFile as TidesJson_TopLevel
}

export const getTides = createServerFn({ method: 'GET' }).handler(async () => {
  return TidalData()
})


export const getTidesForGraph = createServerFn({ method: 'GET' })
  .inputValidator((d: { date: string }) => d)
  .handler(async ({ data }) => {
      const { date } = data;
      const tides = TidalData();
    
      const index = tides.schedule.findIndex((d) => d.date === date);
  
      if (index === -1) {
        throw notFound();
      }
    
      // Work out day before and day of etc
  
      const day = tides.schedule[index];
      const nextDay: string | false =
        index < tides.schedule.length - 1
          ? tides.schedule[index + 1].date
          : false;
      const previousDay: string | false = index > 0 ? tides.schedule[index - 1].date : false;
    
    // Find the data for the graph itself
      const graphStartTimestamp = DateTime.fromSQL(day.date).toJSDate();
      graphStartTimestamp.setHours(0, 0, 0, 0);
      const graphEndTimestamp = new Date(graphStartTimestamp);
      graphEndTimestamp.setDate(graphEndTimestamp.getDate() + 1); // The charts don't work so well beyond a day
      
    let startIndex = tides.schedule.findIndex(
        (date) => {
          return new Date(date.date) >= graphStartTimestamp;
        }
      );
      let endIndex = tides.schedule.findIndex(
        (date) => {
          return new Date(date.date) >= graphEndTimestamp;
        }
      );

      // Adjust indices to include the days immediately before and after the range to capture them in the graph
      startIndex = startIndex > 0 ? startIndex - 1 : startIndex;
      endIndex = endIndex < tides.schedule.length ? endIndex + 1 : endIndex;

      // Slice the array to get the desired elements
      const highTides = tides.schedule
        .slice(startIndex, endIndex)
        .flatMap((date) =>
          date.groups.map((tide) => ({
            timestamp: new Date(date.date + " " + tide.time).getTime() / 1000,
            height: Number(tide.height),
          }))
        );
  
  return { day, nextDay, previousDay, highTides, graphStartTimestamp, graphEndTimestamp };
});