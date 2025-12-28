import {
  Badge,
  Box,
  Button,
  Group,
  Paper,
  rem,
  Text,
} from "@mantine/core";
import {
  IconAlertTriangleFilled,
  IconArrowLeft,
  IconArrowRight,
  IconHome,
} from "@tabler/icons-react";
import { createFileRoute, Link, notFound } from "@tanstack/react-router";
import { DateTime } from "luxon";
// Use relative path for data to be safe or verify alias
import { DataInformation } from "@/components/navigation/DataInformation";
import Layout from "@/components/navigation/Layout";
import { TidalGraph } from "@/components/tideGraph/TidalGraph";
import { getTides } from "@/readTideTimes";

export const Route = createFileRoute("/tide-graph/$date")({
  loader: async ({ params }) => {
    const { date } = params;
    const tidalData = await getTides();
    const index = tidalData.schedule.findIndex((d) => d.date === date);

    if (index === -1) {
      throw notFound();
    }

    const day = tidalData.schedule[index];
    const nextDay: string | false =
      index < tidalData.schedule.length - 1
        ? tidalData.schedule[index + 1].date
        : false;
    const previousDay: string | false = index > 0 ? tidalData.schedule[index - 1].date : false;

    return { tidalData,day, nextDay, previousDay };
  },
  component: TideGraphPageComponent,
  head: ({ loaderData }) => {
    const day = loaderData?.day;
    if (!day) return { meta: [] };
      const pageTitle =
      DateTime.fromSQL(day.date).toLocaleString({
        day: "numeric",
        month: "long",
        year: "numeric",
      }) + " Porthmadog Tide Graph";
      
    return {
        meta: [
            { title: pageTitle },
        ]
    };
  }
});

function TideGraphPageComponent() {
  const { tidalData, day, nextDay, previousDay } = Route.useLoaderData();

  return (
    <Layout
      title={
        DateTime.fromSQL(day.date).toLocaleString({
          day: "numeric",
          month: "long",
          year: "numeric",
        }) + " Porthmadog Tide Graph"
      }
      headerButtons={
        <>
          {previousDay ? (
            <Link to={"/tide-graph/$date"} params={{ date: previousDay }}>
              <Button leftSection={<IconArrowLeft size={14} />} variant="light">
                {DateTime.fromSQL(previousDay).toLocaleString({
                  day: "numeric",
                  month: "short",
                })}
              </Button>
            </Link>
          ) : null}
          <Link to={"/"}>
            <Button variant="light">
              <IconHome size={14} />
            </Button>
          </Link>
          {nextDay ? (
            <Link to={"/tide-graph/$date"} params={{ date: nextDay }}>
              <Button
                leftSection={<IconArrowRight size={14} />}
                variant="light"
              >
                {DateTime.fromSQL(nextDay).toLocaleString({
                  day: "numeric",
                  month: "short",
                })}
              </Button>
            </Link>
          ) : null}
        </>
      }
    >
      <TidalGraph date={DateTime.fromSQL(day.date).toJSDate()} tidalData={tidalData} />
      <Paper shadow="xl" withBorder p="xl">
        <Group justify="flex-start" mb="sm">
          <Badge
            color="red"
            size="xl"
            leftSection={
              <IconAlertTriangleFilled
                style={{ width: rem(15), height: rem(15) }}
              />
            }
          >
            Warning
          </Badge>
          <Text fw={500} tt="uppercase">
            Not to be used for navigation
          </Text>
        </Group>
        <Text>
          {" "}
          Tide Graphs for Porthmadog are not published by authoritative sources
          and should be considered highly unreliable due to seasonal river flows
          and poorly understood tidal dynamics in the estuary. This graph is
          produced by extrapolating from published high water times and heights.
        </Text>
      </Paper>
      <Box p="sm">
        <DataInformation />
      </Box>
    </Layout>
  );
}
