import * as React from "react";
import type { HeadFC, PageProps } from "gatsby";
import {
  Accordion,
  Button,
  Card,
  Center,
  Container,
  Group,
  Image,
  SimpleGrid,
  Text,
} from "@mantine/core";
import Layout from "../components/navigation/Layout";
import { SEO } from "../components/SEO";
import TidalData from "../../data/tides.json";
import { Link } from "gatsby";
import { TidesJson_PDFObject } from "../types";
import { IconArrowLeft, IconArrowRight, IconHome } from "@tabler/icons-react";
import { TideTablesMonthList } from "../components/tideTables/TideTablesMonthList";

const Page: React.FC<PageProps> = () => {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);
  const files = TidalData.pdfs.filter((month: TidesJson_PDFObject) => {
    let date = new Date(month.date);
    return date < nextYear;
  });
  const years = [
    ...new Set(
      files.map((month: TidesJson_PDFObject) => {
        return new Date(month.date).getFullYear();
      })
    ),
  ].map((year) => {
    return {
      year: year as number,
      months: files.filter((month: TidesJson_PDFObject) => {
        return year == new Date(month.date).getFullYear();
      }),
    };
  });
  console.log(years);
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
            <Accordion.Control>{year.year}</Accordion.Control>
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
