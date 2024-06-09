import { LineChart } from "@mantine/charts";
import { Container } from "@mantine/core";
import type { HeadFC, PageProps } from "gatsby";
import { DateTime } from "luxon";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";

const Page: React.FC<PageProps> = () => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const nextWeek = new Date(today);
  nextWeek.setDate(today.getDate() + 2);
  const tides = TidalData.schedule.filter(element => {
    let date = new Date(element.date);
    return date >= today && date <= nextWeek
  });

  return (
    <Layout>
      <Container>
        <LineChart
          h={300}
          data={tides.map(day => day.groups.map(tide => ({
            date: new Date(DateTime.fromSQL(day.date + " " + tide.time).toISO()).getTime() / 1000,
            Height: Number(tide.height)
          }))).flat()}
          dataKey="date"
          xAxisLabel="Date"
          yAxisLabel="Amount"
          yAxisProps={{ domain: [0, 6] }}
          xAxisProps={{ tickFormatter: (date: number) => DateTime.fromMillis(date * 1000).toLocaleString(DateTime.TIME_SIMPLE), domain: [new Date().getTime(), nextWeek.getTime()] }}
          unit="m"
          connectNulls={false}
          series={[
            { name: 'Height', color: 'indigo.6' },
          ]}
          curveType="step"
          gridAxis="y"
        />
      </Container>
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)