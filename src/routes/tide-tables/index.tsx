import { Accordion, Button, Text } from "@mantine/core";
import { IconHome } from "@tabler/icons-react";
import { createFileRoute, Link } from '@tanstack/react-router';
import Layout from "../../components/navigation/Layout";
import { TideTablesMonthList } from "../../components/tideTables/TideTablesMonthList";
import { getTides } from "../../readTideTimes";
export const Route = createFileRoute('/tide-tables/')({
  component: Page,
  loader: async () => {
    const tidalData = await getTides();
    return { tidalData };
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
  })
})
function Page() {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);

  const { tidalData } = Route.useLoaderData();
  const files = tidalData.pdfs.filter((pdf) => {
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