import TidalData from "./data/tides.json";
import path from "path";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "./src/types";
import { BuildArgs, CreatePagesArgs } from "gatsby";
import fs from "fs";
import ical, { ICalEventBusyStatus, ICalEventClass } from "ical-generator";
import { DateTime } from "luxon";

export const createPages = async function ({
  actions,
  graphql,
}: CreatePagesArgs) {
  TidalData.pdfs.forEach((pdf: TidesJson_PDFObject) => {
    actions.createPage({
      path: "/tide-tables/" + pdf.url,
      component: path.resolve(`./src/components/templates/TideTablePage.tsx`),
      context: { pdf },
      defer: false,
    });
    actions.createRedirect({
      fromPath: "/tide-tables/" + pdf.url.replace("/", "-"),
      toPath: "/tide-tables/" + pdf.url,
    });
    actions.createRedirect({
      fromPath: "/tide-tables/" + pdf.url.replace("/", "-") + ".pdf",
      toPath: "/tide-tables/" + pdf.url + ".pdf",
    });
  });

  // Legacy page
  actions.createRedirect({
    fromPath: "/historical-tables",
    toPath: "/tide-tables",
  });
};

export const onPostBootstrap = function ({ reporter }: BuildArgs) {
  reporter.info(`Generating iCal file for tide times`);
  const cal = ical();
  cal.timezone("Europe/London");
  cal.name("Porthmadog Tide Times");
  cal.description(
    "Tide times for Porthmadog, Borth-y-gest, Morfa Bychan and Black Rock Sands from Port-Tides.com"
  );
  TidalData.schedule.forEach((day: TidesJson_ScheduleObject) =>
    day.groups.forEach((tide) => {
      cal.createEvent({
        start: DateTime.fromSQL(day.date + " " + tide.time).toJSDate(),
        end: DateTime.fromSQL(day.date + " " + tide.time)
          .plus({ minutes: 30 })
          .toJSDate(),
        summary: `High Tide - ${tide.height}m`,
        busystatus: ICalEventBusyStatus.FREE,
        class: ICalEventClass.PUBLIC,
        description: {
          plain: `High Tide ${tide.height}m at ${tide.time}`,
          html: `High Tide ${tide.height}m at ${tide.time}. More details at <a href="https://port-tides.com/">port-tides.com</a>`,
        },
        location: {
          title: "Porthmadog",
          address: "Harbwr Porthmadog, LL49 9AY, UK",
        },
        url: "https://port-tides.com/tide-tables",
      });
    })
  );
  fs.writeFileSync("public/porthmadog-tides.ical", cal.toString());
  reporter.success(
    `Generated iCal file for tide times at public/porthmadog-tides.ical`
  );
};
