import { DataInformation } from "@/components/navigation/DataInformation";
import Layout from "@/components/navigation/Layout";
import { TideTable } from "@/components/tideTables/TideTable";
import { TideTableMobile } from "@/components/tideTables/TideTableMobile";
import { getTides } from "@/readTideTimes";
import {
  Box,
  Button,
} from "@mantine/core";
import {
  IconArrowLeft,
  IconDownload,
  IconFileTypePdf,
} from "@tabler/icons-react";
import { createFileRoute, Link, notFound, redirect } from "@tanstack/react-router";
import { DateTime } from "luxon";

export const Route = createFileRoute("/tide-tables/$")({
  loader: async ({ params }) => {
    const url = params._splat;
    const tidalData = await getTides();
    const pdf = tidalData.pdfs.find((p) => p.url === url);

    if (!pdf) {
      // Check for dashed version of the date in the URL (ie 2025-12 instead of 2025/12)
       const pdfByDashed = tidalData.pdfs.find((p) => p.url.replace(/\//g, "-") === url);
       if (pdfByDashed) {
         throw redirect({
           to: "/tide-tables/$",
           params: { _splat: pdfByDashed.url },
           statusCode: 301
         });
       }
      throw notFound();
    }

    const firstDayOfMonth = pdf.date;
    const monthMatch =
      firstDayOfMonth.split("-")[0] + "-" + firstDayOfMonth.split("-")[1];
    const tides = tidalData.schedule.filter((date) => {
      return date.date.startsWith(monthMatch);
    });

    return { pdf, tides };
  },
  component: TideTablePageComponent,
  head: ({ loaderData }) => {
      const pdf = loaderData?.pdf;
      if (!pdf) return { meta: [] };
      const firstDayOfMonth = pdf.date;
      const pageTitle =
        DateTime.fromSQL(firstDayOfMonth).toLocaleString({
          month: "long",
          year: "numeric",
        }) + " Porthmadog Tide Table";
      
      return {
          meta: [
              { title: pageTitle },
          ]
      };
  }
});

function TideTablePageComponent() {
  const { pdf, tides } = Route.useLoaderData();
  
  const firstDayOfMonth = pdf.date;
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
          <Link to={"/tide-tables"}>
            <Button leftSection={<IconArrowLeft size={14} />} variant="light">
              Other Months
            </Button>
          </Link>
          <a href={"/tide-tables/" + pdf.filename} download>
            <Button
              rightSection={<IconFileTypePdf size={14} />}
              leftSection={<IconDownload size={14} />}
              variant="light"
            >
              Download
            </Button>
          </a>
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
}
