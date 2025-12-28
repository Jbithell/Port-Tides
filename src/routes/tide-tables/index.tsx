import { Accordion, Button, Text } from "@mantine/core";
import { IconHome } from "@tabler/icons-react";
import { createFileRoute, Link } from '@tanstack/react-router';
import Layout from "../../components/navigation/Layout";
import { TideTablesMonthList } from "../../components/tideTables/TideTablesMonthList";
import { getPDFs } from "../../readTideTimes";
export const Route = createFileRoute('/tide-tables/')({
  component: Page,
  loader: async () => {
    const pdfs = await getPDFs();
    return { pdfs };
  },
  head: () => ({
    meta: [
      {
        title: 'Downloadable Tide Tables | Porthmadog Tide Times',
      },
      {
        name: 'description',
        content: 'Downloadable tide tables for Porthmadog, Borth-y-gest, Morfa Bychan and Black Rock Sands',
      },
    ],

    links: [
      {
        rel: 'canonical',
        href: `https://port-tides.com/tide-tables`,
      },
    ],
    scripts: [
      {
        type: 'application/ld+json',
        children: JSON.stringify({
          '@context': 'https://schema.org',
          '@type': 'CollectionPage',
          name: 'Downloadable Tide Tables',
          description: 'Download free printable tide tables for Porthmadog, Borth-y-gest, and Black Rock Sands. Available in monthly PDF format.',
          author: {
            '@type': 'Organization',
            name: 'Porthmadog Tide Times',
          },
          datePublished: new Date().toISOString(),
        }),
      },
    ],
  })
})
function Page() {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);

  const { pdfs } = Route.useLoaderData();
  const files = pdfs.filter((pdf) => {
    let date = new Date(pdf.date);
    return date < nextYear;
  });
  const years = [
    ...new Set(
      files.map((month) => {
        return new Date(month.date).getFullYear();
      })
    ),
  ]
    .map((year) => {
      return {
        year: year as number,
        months: files.filter((month) => {
          return year == new Date(month.date).getFullYear();
        }),
      };
    })
    .reverse();
  return (
    <Layout
      title="Downloadable Tide Tables"
      headerButtons={
        <Link to={"/"}>
          <Button leftSection={<IconHome size={14} />} variant="light">
            Homepage
          </Button>
        </Link>
      }
    >
      <Accordion
        multiple
        defaultValue={[
          month.getFullYear() + "-tab",
          month.getFullYear() + 1 + "-tab",
        ]}
      >
        {years.map((year) => (
          <Accordion.Item key={year.year} value={year.year + "-tab"}>
            <Accordion.Control>
              <Text size="xl" fw={500} mb={"xs"}>
                {year.year}
              </Text>
            </Accordion.Control>
            <Accordion.Panel>
              <TideTablesMonthList files={year.months} />
            </Accordion.Panel>
          </Accordion.Item>
        ))}
      </Accordion>
    </Layout>
  );
};