import * as React from "react";
import { Link, type HeadFC, type PageProps } from "gatsby";
import {
  Badge,
  Button,
  Card,
  Center,
  Container,
  Group,
  Image,
  SimpleGrid,
  Text,
  Title,
  useMatches,
} from "@mantine/core";
import Logo from "./../images/porthmadogCob.jpg";
import Layout from "../components/navigation/Layout";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import { DateTime } from "luxon";
import { LineChart } from "@mantine/charts";
import { TidesJson_ScheduleObject } from "../types";
import { IconArrowRight, IconTable } from "@tabler/icons-react";

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
        <Title order={1} size={"h1"}>
          Porthmadog Tide Times
        </Title>
      </Center>
      <Group justify="space-between" mb="sm" mt="sm">
        <Title order={2} size={"h3"}>
          High Tide Times this week
        </Title>
        <Link
          to={
            "tide-tables/" +
            DateTime.fromJSDate(nextWeek).toLocaleString({
              year: "numeric",
            }) +
            "/" +
            DateTime.fromJSDate(nextWeek).toLocaleString({
              month: "2-digit",
            })
          }
        >
          <Button
            leftSection={<IconTable size={14} />}
            variant="light"
            visibleFrom="sm"
          >
            {DateTime.fromJSDate(nextWeek).toLocaleString({
              month: "long",
            })}{" "}
            Tide Table
          </Button>
        </Link>
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
            "/tide-tables/" +
            DateTime.fromJSDate(nextWeek).toLocaleString({
              year: "numeric",
            }) +
            "/" +
            DateTime.fromJSDate(nextWeek).toLocaleString({
              month: "2-digit",
            })
          }
          style={{ textDecoration: "none" }}
        >
          <Card shadow="xs" padding={"xs"} hiddenFrom="sm">
            <Group justify="space-between">
              <Text size="xl" fw={500}>
                {DateTime.fromJSDate(nextWeek).toLocaleString({
                  month: "long",
                })}{" "}
                Tide Table
              </Text>
              <IconArrowRight />
            </Group>
          </Card>
        </Link>
      </SimpleGrid>
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = () => <SEO />;
