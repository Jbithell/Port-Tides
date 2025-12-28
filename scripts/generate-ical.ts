import fs from "fs";
import ical from "ical-generator";
import { DateTime } from "luxon";
import TidalData from "../data/tides.json" with { type: "json" };

// Type definitions to match data structure
interface TidesJson_ScheduleObject {
  date: string;
  groups: Array<{
    time: string;
    height: string;
  }>;
  sunrise: string;
  sunset: string;
}

const generateIcal = () => {
  console.log(`Generating iCal file for tide times`);
  const cal = ical();
  cal.timezone("Europe/London");
  cal.name("Porthmadog Tide Times");
  cal.description(
    "Tide times for Porthmadog, Borth-y-gest, Morfa Bychan and Black Rock Sands from Port-Tides.com"
  );
  
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const nextYear = new Date(today);
  nextYear.setDate(today.getDate() + 365);
  
  // Cast TidalData to any or typed structure because direct import might be typed generic
  const schedule = (TidalData as any).schedule as TidesJson_ScheduleObject[];

  schedule
    .filter((timeDay) => {
      let date = new Date(timeDay.date);
      return date >= today && date <= nextYear;
    })
    .forEach((day) =>
      day.groups.forEach((tide) => {
        cal.createEvent({
          start: DateTime.fromSQL(day.date + " " + tide.time).toJSDate(),
          end: DateTime.fromSQL(day.date + " " + tide.time)
            .plus({ minutes: 30 })
            .toJSDate(),
          summary: `High Tide Porthmadog - ${tide.height}m`,
          description: {
            plain: "Powered by port-tides.com",
            html: `More details at <a href="https://port-tides.com/">port-tides.com</a>`,
          },
          //  Commented out to reduce file size
          /*location: {
            title: "Porthmadog",
            address: "Harbwr Porthmadog, LL49 9AY, UK",
          },
          busystatus: ICalEventBusyStatus.FREE, // If ICalEventBusyStatus import needed, add it or use string
          class: ICalEventClass.PUBLIC,
          url: "https://port-tides.com/tide-tables",*/
        });
      })
    );
    
  // Ensure public dir exists
  if (!fs.existsSync("public")) {
      fs.mkdirSync("public");
  }
  
  fs.writeFileSync("public/porthmadog-tides.ical", cal.toString());
  console.log(
    `Generated iCal file for tide times at public/porthmadog-tides.ical`
  );
};

generateIcal();
