import * as React from "react";
import { Link, type HeadFC, type PageProps } from "gatsby";
import { Badge, Box, Button, Group, Paper, rem, Text } from "@mantine/core";
import TidalData from "../../../data/tides.json";
import { SEO } from "../SEO";
import Layout from "../navigation/Layout";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";
import {
  IconAlertTriangleFilled,
  IconArrowLeft,
  IconArrowRight,
  IconDownload,
  IconExclamationCircle,
  IconFileTypePdf,
  IconHome,
} from "@tabler/icons-react";
import { TideTable } from "../tideTables/TideTable";
import { TideTableMobile } from "../tideTables/TideTableMobile";
import { DataInformation } from "../navigation/DataInformation";
import { TidalGraph } from "../tideGraph/TidalGraph";

const Page: React.FC<PageProps> = ({ pageContext }) => {
  const { day, previousDay, nextDay } = pageContext as {
    day: TidesJson_ScheduleObject;
    previousDay: string | false;
    nextDay: string | false;
  };
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
            <Link to={"/tide-graph/" + previousDay}>
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
            <Link to={"/tide-graph/" + nextDay}>
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
      <TidalGraph date={DateTime.fromSQL(day.date).toJSDate()} />
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
};

export default Page;

export const Head: HeadFC = ({ pageContext }) => {
  const { day } = pageContext as { day: TidesJson_PDFObject };
  const pageTitle =
    DateTime.fromSQL(day.date).toLocaleString({
      day: "numeric",
      month: "long",
      year: "numeric",
    }) + " Porthmadog Tide Graph";
  return <SEO title={pageTitle} />;
};
