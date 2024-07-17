import * as React from "react";
import { Link, type HeadFC, type PageProps } from "gatsby";
import { Box, Button, Text } from "@mantine/core";
import TidalData from "../../../data/tides.json";
import { SEO } from "../SEO";
import Layout from "../navigation/Layout";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";
import {
  IconArrowLeft,
  IconArrowRight,
  IconDownload,
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
  console.log(day);
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
      <TidalGraph date={new Date(day.date).getTime()} />
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
