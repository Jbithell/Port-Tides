import * as React from "react"
import type { HeadFC, PageProps } from "gatsby"
import { Center, Container, Image, Text } from "@mantine/core"
import Layout from "../components/navigation/Layout"
import { SEO } from "../components/SEO";
import TidalData from "../../data/tides.json";
import { Link } from "gatsby";
import { TidesJson_PDFObject } from "../types";


const Page: React.FC<PageProps> = () => {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);
  const files = TidalData.pdfs.filter((element: TidesJson_PDFObject) => {
    let date = new Date(element.date);
    return date < nextYear;
  });
  return (
    <Layout>
      <Center>
        {files.map((element: TidesJson_PDFObject, index: React.Key) => (<a href={"/tide-tables/" + element.url + "/"} key={index}>{element.name}</a>))}
      </Center>
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)