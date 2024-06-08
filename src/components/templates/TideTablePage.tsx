import * as React from "react"
import type { HeadFC, PageProps } from "gatsby"
import { Center, Container, Image, Text } from "@mantine/core"
import TidalData from "../../../data/tides.json";
//import Layout from "../../components/navigation/Layout"
import { SEO } from "../../components/SEO";
import Layout from "../navigation/Layout";


const Page: React.FC<PageProps> = ({ pageContext }: { pageContext: any }) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const nextWeek = new Date(today);
  nextWeek.setDate(today.getDate() + 7);
  const tides = TidalData.schedule.filter(element => {
    let date = new Date(element.date);
    return date >= today && date <= nextWeek
  });
  console.log(pageContext)
  return (
    <Layout>
      Test page
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)