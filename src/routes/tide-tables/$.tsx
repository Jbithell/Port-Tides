import { DataInformation } from "@/components/navigation/DataInformation";
import Layout from "@/components/navigation/Layout";
import { TideTable } from "@/components/tideTables/TideTableDesktop";
import { TideTableMobile } from "@/components/tideTables/TideTableMobile";
import { getTidesForMonth } from "@/readTideTimes";
import {
  Box,
  Button,
  Center,
  Title,
} from "@mantine/core";
import {
  IconArrowLeft,
  IconDownload,
  IconFileTypePdf,
} from "@tabler/icons-react";
import { createFileRoute, Link, notFound } from "@tanstack/react-router";
import { DateTime } from "luxon";

export const Route = createFileRoute("/tide-tables/$")({
  loader: async ({ params }) => {
    const url = params._splat;
    if (!url) {
      throw notFound();
    }
    return await getTidesForMonth({
      data: {
        url,
      }
    });
  },
  component: TideTablePageComponent,
  head: ({ loaderData }) => {
    const pdf = loaderData?.pdf;
    if (!pdf) return { meta: [] };
    const firstDayOfMonth = pdf.date;
    const pageTitle =
      DateTime.fromSQL(firstDayOfMonth).toFormat("MMMM yyyy") + " Porthmadog Tide Table";

    return {
      meta: [
        { title: pageTitle },
      ],
      links: [
        {
          rel: 'canonical',
          href: `https://port-tides.com/tide-tables/${pdf.url}`,
        },
      ],
      scripts: [
        {
          type: 'application/ld+json',
          children: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'WebPage',
            name: pageTitle,
            description: `Porthmadog tide times for ${pageTitle}. High and low tide times and heights.`,
            author: {
              '@type': 'Organization',
              name: 'Porthmadog Tide Times',
            },
            datePublished: new Date().toISOString(),
            mainEntity: {
              '@type': 'Dataset',
              name: pageTitle,
              description: `Tide table data for Porthmadog for ${pageTitle}`,
              license: 'https://creativecommons.org/licenses/by/4.0/',
            }
          }),
        },
      ],
    };
  },
  headers: () => {
    return {
      'Cache-Control': `public, max-age=604800, s-maxage=31536000`, // Cache for 7 days client side, 1 year CDN side
    }
  },
});

function TideTablePageComponent() {
  const { pdf, tides } = Route.useLoaderData();

  const firstDayOfMonth = pdf.date;
  const pageTitle =
    DateTime.fromSQL(firstDayOfMonth).toFormat("MMMM yyyy") + " Porthmadog Tide Table";

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
        <Center><Title order={2} my="sm">High Tide Times</Title></Center>
        <TideTableMobile data={tides} />
      </Box>
      <Box visibleFrom="sm">
        <TideTable data={tides} />
      </Box>
      <Box p="sm">
        <DataInformation />
      </Box>
    </Layout >
  );
}
