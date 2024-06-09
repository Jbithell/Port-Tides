import * as React from "react";
import { Link, type HeadFC, type PageProps } from "gatsby";
import {
  Box,
  Button,
} from "@mantine/core";
import TidalData from "../../../data/tides.json";
import { SEO } from "../../components/SEO";
import Layout from "../navigation/Layout";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";
import {
  IconArrowLeft,
  IconDownload,
  IconFileTypePdf,
} from "@tabler/icons-react";
import { TideTable } from "../tideTables/TideTable";
import { TideTableMobile } from "../tideTables/TideTableMobile";
import { DataInformation } from "../navigation/DataInformation";

const Page: React.FC<PageProps> = ({ pageContext }) => {
  const { pdf } = pageContext as { pdf: TidesJson_PDFObject };
  const firstDayOfMonth = pdf.date;
  const monthMatch =
    firstDayOfMonth.split("-")[0] + "-" + firstDayOfMonth.split("-")[1];
  const tides = TidalData.schedule.filter((date: TidesJson_ScheduleObject) => {
    return date.date.startsWith(monthMatch);
  });
  const pageTitle =
    DateTime.fromSQL(firstDayOfMonth).toLocaleString({
      month: "long",
      year: "numeric",
    }) + " Porthmadog Tide Table";
  return (
    <Layout
      title={pageTitle}
      headerButtons={
        <>
          <Link to={"/tide-tables/"}>
            <Button leftSection={<IconArrowLeft size={14} />} variant="light">
              Other Months
            </Button>
          </Link>
          <Link to={"/tide-tables/" + pdf.filename}>
            <Button
              rightSection={<IconFileTypePdf size={14} />}
              leftSection={<IconDownload size={14} />}
              variant="light"
            >
              Download
            </Button>
          </Link>
        </>
      }
    >
      <Box hiddenFrom="sm">
        <TideTableMobile data={tides} />
      </Box>
      <Box visibleFrom="sm">
        <TideTable data={tides} />
      </Box>
      <Box p="sm">
        <DataInformation />
      </Box>
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = ({ pageContext }) => {
  const { pdf } = pageContext as { pdf: TidesJson_PDFObject };
  const firstDayOfMonth = pdf.date;
  const pageTitle =
    DateTime.fromSQL(firstDayOfMonth).toLocaleString({
      month: "long",
      year: "numeric",
    }) + " Porthmadog Tide Table";
  return <SEO title={pageTitle} />;
};
