import {
  Button,
  Card,
  Center,
  Group,
  SimpleGrid,
  Stack,
  Text,
  Title,
  useMatches,
} from "@mantine/core";
import {
  IconArrowRight,
  IconCalendar,
  IconChartHistogram,
  IconTable,
} from "@tabler/icons-react";
import { Link, type HeadFC, type PageProps } from "gatsby";
import { DateTime } from "luxon";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";
import { TideTablesIndexList } from "../components/tideTables/TidesTablesIndexList";
import { TidesJson_ScheduleObject } from "../types";

const Page: React.FC<PageProps> = () => {
  const daysToDisplay = useMatches({ base: 5, sm: 6, md: 8, lg: 10, xl: 10 });
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const nextWeek = new Date(today);
  nextWeek.setDate(today.getDate() + daysToDisplay);
  const tides = TidalData.schedule.filter(
    (tideDay: TidesJson_ScheduleObject) => {
      let date = new Date(tideDay.date);
      return date >= today && date <= nextWeek;
    }
  );
  return (
    <Layout>
      <Center>
        <Stack align="center" gap={"sm"}>
          <Title order={1} size={"h1"} mb={0}>
            Porthmadog Tide Times
          </Title>
          <Text fw={200}>North Wales, United Kingdom</Text>
        </Stack>
      </Center>
      <Group justify="space-between" mb="sm" mt="sm">
        <Title order={2} size={"h3"}>
          High Tide Times this week
        </Title>
        <Group justify="flex-end">
          <Link
            to={
              "/tide-graph/" + DateTime.fromJSDate(today).toFormat("yyyy-LL-dd")
            }
            style={{ textDecoration: "none" }}
          >
            <Button
              rightSection={<IconChartHistogram size={14} />}
              variant="light"
              visibleFrom="sm"
            >
              Today's Graph
            </Button>
          </Link>
          <Link
            to={"tide-tables/" + DateTime.fromJSDate(today).toFormat("yyyy/LL")}
          >
            <Button
              leftSection={<IconTable size={14} />}
              variant="light"
              visibleFrom="sm"
            >
              {DateTime.fromJSDate(today).toLocaleString({
                month: "long",
              })}{" "}
              Tide Table
            </Button>
          </Link>
        </Group>
      </Group>
      <SimpleGrid cols={{ base: 1, sm: 3, md: 4, lg: 5, xl: 5 }}>
        {tides.map((element: TidesJson_ScheduleObject, index: React.Key) => (
          <Card shadow="xs" padding={"xs"} key={index}>
            <Text size="xl" fw={500} mb={"xs"}>
              {DateTime.fromSQL(element.date).toLocaleString({
                weekday: "long",
                day: "2-digit",
                month: "long",
              })}
            </Text>
            {element.groups.map((tide) => (
              <Group justify="start" mt={0} mb={0}>
                <Text size="lg" fw={500}>
                  {DateTime.fromSQL(
                    element.date + " " + tide.time
                  ).toLocaleString(DateTime.TIME_SIMPLE)}
                </Text>
                <Text size="lg" fw={200}>
                  {tide.height}m
                </Text>
              </Group>
            ))}
          </Card>
        ))}
        <Link
          to={
            "/tide-graph/" + DateTime.fromJSDate(today).toFormat("yyyy-LL-dd")
          }
          style={{ textDecoration: "none" }}
        >
          <Card shadow="xs" padding={"xs"} hiddenFrom="sm">
            <Group justify="space-between">
              <Text size="xl" fw={500}>
                Today's Graph
              </Text>
              <IconChartHistogram />
            </Group>
          </Card>
        </Link>
        <Link
          to={"/tide-tables/" + DateTime.fromJSDate(today).toFormat("yyyy/LL")}
          style={{ textDecoration: "none" }}
        >
          <Card shadow="xs" padding={"xs"} hiddenFrom="sm">
            <Group justify="space-between">
              <Text size="xl" fw={500}>
                {DateTime.fromJSDate(today).toLocaleString({
                  month: "long",
                })}{" "}
                Tide Table
              </Text>
              <IconArrowRight />
            </Group>
          </Card>
        </Link>
      </SimpleGrid>
      <Group justify="space-between" mb="sm" mt="sm">
        <Title order={2} size={"h3"}>
          Monthly Tide Tables
        </Title>
        <Group justify="flex-end">
          <Link to={"ical/"}>
            <Button rightSection={<IconCalendar size={14} />} variant="light">
              Add to Calendar
            </Button>
          </Link>
          <Link to={"tide-tables/"}>
            <Button rightSection={<IconArrowRight size={14} />} variant="light">
              View All
            </Button>
          </Link>
        </Group>
      </Group>
      <TideTablesIndexList />
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = () => <SEO />;
