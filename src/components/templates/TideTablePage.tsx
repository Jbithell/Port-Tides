import * as React from "react"
import type { HeadFC, PageProps } from "gatsby"
import { Card, Center, Container, Group, Image, Table, Text } from "@mantine/core"
import TidalData from "../../../data/tides.json";
import { SEO } from "../../components/SEO";
import Layout from "../navigation/Layout";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";


const Page: React.FC<PageProps> = ({ pageContext }) => {
  const { pdf } = pageContext as { pdf: TidesJson_PDFObject };
  const firstDayOfMonth = pdf.date;
  const monthMatch = firstDayOfMonth.split("-")[0] + firstDayOfMonth.split("-")[1];
  const tides = TidalData.schedule.filter((element: TidesJson_ScheduleObject) => {
    return element.date.startsWith(monthMatch)
  });
  return (
    <Layout>
      <Table>
        <Table.Thead>
          <Table.Tr>
            <Table.Th>Date</Table.Th>
            <Table.Th>Sunrise</Table.Th>
            <Table.Th>Time</Table.Th>
            <Table.Th>Height</Table.Th>
            <Table.Th>Time</Table.Th>
            <Table.Th>Height</Table.Th>
            <Table.Th>Sunset</Table.Th>
          </Table.Tr>
        </Table.Thead>
        <Table.Tbody>
          {tides.map((element: TidesJson_ScheduleObject, index: React.Key) => (
            element.groups.map(tide => (
              <Table.Tr key={index}>
                <Table.Td>{DateTime.fromSQL(element.date).toLocaleString({ weekday: "long", day: "2-digit" })}</Table.Td>
                {element.groups.map(tide => (
                    <>
                      <Table.Td>{DateTime.fromSQL(element.date + " " + tide.time).toLocaleString(DateTime.TIME_SIMPLE)}</Table.Td>
                      <Table.Td>{tide.height}</Table.Td>
                    </>
                  ))}
                  {element.groups.length === 1 ? <Table.Td colSpan={2}></Table.Td> : null}
                </Table.Tr>
              ))
          ))}
        </Table.Tbody>
      </Table>
    </Layout>
  )
}

export default Page

export const Head: HeadFC = () => (
  <SEO />
)