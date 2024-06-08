import * as React from "react"
import type { HeadFC, PageProps } from "gatsby"
import { Card, Center, Container, Group, Image, Text } from "@mantine/core"
import TidalData from "../../../data/tides.json";
import { SEO } from "../../components/SEO";
import Layout from "../navigation/Layout";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";


const Page: React.FC<PageProps> = ({ pageContext }: { pageContext: { pdf: TidesJson_PDFObject } }) => {
  const firstDayOfMonth = pageContext.pdf.date;
  const monthMatch = firstDayOfMonth.split("-")[0] + firstDayOfMonth.split("-")[1];
  const tides = TidalData.schedule.filter((element: TidesJson_ScheduleObject) => {
    return element.date.startsWith(monthMatch)
  });
  console.log(tides)
  return (
    <Layout>
      {tides.map((element: TidesJson_ScheduleObject, index: React.Key) => (
        <Card shadow="xs" key={index}>

          <Text size="xl" fw={500}>{DateTime.fromSQL(element.date).toLocaleString({ weekday: "long", day: "2-digit", month: "long" })}</Text>
          {element.groups.map(tide => (
            <Group justify="start" mt="md" mb="xs">
              <Text size="lg" fw={500} >{DateTime.fromSQL(element.date + " " + tide.time).toLocaleString(DateTime.TIME_SIMPLE)}</Text>
              <Text size="lg" fw={200}>{tide.height}m</Text>
            </Group>
          ))}
        </Card>
      ))}
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)