import { Accordion, Button, Text } from "@mantine/core";
import { IconHome } from "@tabler/icons-react";
import type { HeadFC, PageProps } from "gatsby";
import { Link } from "gatsby";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";
import { TideTablesMonthList } from "../components/tideTables/TideTablesMonthList";
import { TidesJson_PDFObject } from "../types";

const Page: React.FC<PageProps> = () => {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);
  const files = TidalData.pdfs.filter((pdf: TidesJson_PDFObject) => {
    let date = new Date(pdf.date);
    return date < nextYear;
  });
  const years = [
    ...new Set(
      files.map((month: TidesJson_PDFObject) => {
        return new Date(month.date).getFullYear();
      })
    ),
  ]
    .map((year) => {
      return {
        year: year as number,
        months: files.filter((month: TidesJson_PDFObject) => {
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

export default Page;

export const Head: HeadFC = () => <SEO title="Downloadable Tide Tables" />;
