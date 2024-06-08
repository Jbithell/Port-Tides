import * as React from "react"
import type { HeadFC, PageProps } from "gatsby"
import { Badge, Card, Center, Container, Group, Image, SimpleGrid, Text, Title, useMatches } from "@mantine/core"
import Logo from "./../images/porthmadogCob.jpg";
import Layout from "../components/navigation/Layout"
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import { DateTime } from "luxon";
import { LineChart } from "@mantine/charts";
import { TidesJson_ScheduleObject } from "../types";

const Page: React.FC<PageProps> = () => {
  const daysToDisplay = useMatches({ base: 5, sm: 6, md: 8, lg: 10, xl: 10 });
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const nextWeek = new Date(today);
  nextWeek.setDate(today.getDate() + daysToDisplay);
  const tides = TidalData.schedule.filter((element: TidesJson_ScheduleObject) => {
    let date = new Date(element.date);
    return date >= today && date <= nextWeek
  });
  return (
    <Layout>
      <SimpleGrid
        cols={{ base: 1, sm: 3, md: 4, lg: 5, xl: 5 }}
      >
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
      </SimpleGrid>
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)