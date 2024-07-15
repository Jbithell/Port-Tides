import { LineChart } from "@mantine/charts";
import { Container, Paper, Text } from "@mantine/core";
import type { HeadFC, PageProps } from "gatsby";
import { DateTime } from "luxon";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";
import { TidesJson_ScheduleObject } from "../types";
import { generateTideGraphData } from "../components/tideGraph/graphDataGenerator";

interface ChartTooltipProps {
  label: string;
  payload: Record<string, any>[] | undefined;
}

function ChartTooltip({ label, payload }: ChartTooltipProps) {
  if (!payload) return null;

  return (
    <Paper px="md" py="sm" withBorder shadow="md" radius="md">
      <Text fw={500} mb={5}>
        {new Date(Number(label) * 1000).toLocaleDateString("en-GB", {
          day: "numeric",
          month: "short",
          year: "numeric",
          hour: "numeric",
          minute: "numeric",
        })}
      </Text>
      {payload.map((item: any) => (
        <Text key={item.name} c={item.color} fz="sm">
          {item.name}: {item.value}m
        </Text>
      ))}
    </Paper>
  );
}

const Page: React.FC<PageProps> = () => {
  const startTimestamp = new Date();
  startTimestamp.setHours(0, 0, 0, 0);
  const endTimestamp = new Date(startTimestamp);
  endTimestamp.setDate(endTimestamp.getDate() + 0); // 2
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

  const graphData = generateTideGraphData(highTides);

  return (
    <Layout>
      <Container>
        <LineChart
          h={800}
          data={graphData}
          dataKey="date"
          xAxisLabel="Date"
          yAxisLabel="Height"
          yAxisProps={{
            domain: [0, 5.5],
            allowDataOverflow: false,
          }}
          xAxisProps={{
            tickFormatter: (value: number) =>
              new Date(value * 1000).toLocaleDateString("en-GB", {
                day: "numeric",
                month: "short",
                hour: "numeric",
                minute: "numeric",
              }),
            //domain: [new Date().getTime(), nextWeek.getTime()],
          }}
          tooltipProps={{
            content: ({ label, payload }) => (
              <ChartTooltip label={label} payload={payload} />
            ),
          }}
          unit="m"
          connectNulls={false}
          series={[{ name: "Height", color: "indigo.6" }]}
          curveType="natural"
          gridAxis="y"
        />
      </Container>
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = () => <SEO />;
