import { LineChart } from "@mantine/charts";
import { Container } from "@mantine/core";
import type { HeadFC, PageProps } from "gatsby";
import { DateTime } from "luxon";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";
import { TidesJson_ScheduleObject } from "../types";

const Page: React.FC<PageProps> = () => {
  const startTimestamp = new Date();
  startTimestamp.setHours(0, 0, 0, 0);
  const endTimestamp = new Date(startTimestamp);
  endTimestamp.setDate(endTimestamp.getDate() + 2);
  let startIndex = TidalData.schedule.findIndex(
    (date: TidesJson_ScheduleObject) => {
      return new Date(date.date) >= startTimestamp;
    }
  );
  let endIndex = TidalData.schedule.findIndex(
    (date: TidesJson_ScheduleObject) => {
      return new Date(date.date) > endTimestamp;
    }
  );

  // Adjust indices to include the days immediately before and after the range
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

  const highAndLowTides = [];
  for (let i = 0; i < highTides.length; i++) {
    highAndLowTides.push(highTides[i]);
    if (i < highTides.length - 1) {
      highAndLowTides.push({
        timestamp:
          highTides[i].timestamp +
          (highTides[i + 1].timestamp - highTides[i].timestamp) / 2,
        height: 0,
      });
    }
  }
  console.log(highAndLowTides);
  return (
    <Layout>
      <Container>
        <LineChart
          h={300}
          data={highAndLowTides
            .map((tide) => ({
              date: tide.timestamp,
              Height: Number(tide.height),
            }))
            .flat()}
          dataKey="date"
          xAxisLabel="Date"
          yAxisLabel="Amount"
          yAxisProps={{ domain: [0, 6] }}
          xAxisProps={
            {
              //tickFormatter: (date: number) =>
              //  DateTime.fromMillis(date * 1000).toLocaleString(
              //    DateTime.TIME_SIMPLE
              //  ),
              //domain: [new Date().getTime(), nextWeek.getTime()],
            }
          }
          unit="m"
          connectNulls={false}
          series={[{ name: "Height", color: "indigo.6" }]}
          curveType="step"
          gridAxis="y"
        />
      </Container>
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = () => <SEO />;
