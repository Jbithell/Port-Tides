import { ActionIcon, Badge, Table, Text } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import {
  IconChartHistogram,
  IconSunrise,
  IconSunset,
  IconX,
} from "@tabler/icons-react";
import { Link } from "@tanstack/react-router";
import { DateTime } from "luxon";
import React from "react";
import { TidesJson_ScheduleObject } from "../../types";

export function TideTable({ data }: { data: TidesJson_ScheduleObject[] }) {
  const [showSunriseSunset, sunriseSunsetHandlers] = useDisclosure(true);
  return (
    <Table highlightOnHover stickyHeader stickyHeaderOffset={60}>
      <Table.Thead>
        <Table.Tr>
          <Table.Th>Date</Table.Th>
          {showSunriseSunset && <Table.Th>Sunrise <ActionIcon variant="subtle" size="xs" aria-label="Hide Sunrise/Sunset" onClick={() => sunriseSunsetHandlers.close()}><IconX style={{ width: '70%', height: '70%' }} stroke={1.5} /></ActionIcon></Table.Th>}
          <Table.Th>High Tide</Table.Th>
          <Table.Th>Height</Table.Th>
          <Table.Th>High Tide</Table.Th>
          <Table.Th>Height</Table.Th>
          {showSunriseSunset && <Table.Th>Sunset <ActionIcon variant="subtle" size="xs" aria-label="Hide Sunrise/Sunset" onClick={() => sunriseSunsetHandlers.close()}><IconX style={{ width: '70%', height: '70%' }} stroke={1.5} /></ActionIcon></Table.Th>}
          <Table.Th></Table.Th>
        </Table.Tr>
      </Table.Thead>
      <Table.Tbody>
        {data.map((date: TidesJson_ScheduleObject, index: React.Key) => (
          <Table.Tr key={index}>
            <Table.Td>
              <Text>
                {DateTime.fromSQL(date.date).toFormat("cccc dd")}
                {DateTime.fromSQL(date.date).toJSDate().setHours(0, 0, 0, 0) ==
                  new Date().setHours(0, 0, 0, 0) ? (
                  <Badge ml="sm">Today</Badge>
                ) : null}
              </Text>
            </Table.Td>
            {showSunriseSunset && <Table.Td>
              <Text>
                {date.sunrise} <IconSunrise size={14} />
              </Text>
            </Table.Td>}
            {date.groups.map((tide) => (
              <>
                <Table.Td>
                  <Text>
                    {DateTime.fromSQL(
                      date.date + " " + tide.time
                    ).toFormat("HH:mm")}
                  </Text>
                </Table.Td>
                <Table.Td>
                  <Text>{tide.height}m</Text>
                </Table.Td>
              </>
            ))}
            {date.groups.length === 1 ? (
              <Table.Td colSpan={2}></Table.Td>
            ) : null}
            {showSunriseSunset && <Table.Td>
              <Text>
                {date.sunset} <IconSunset size={14} />
              </Text>
            </Table.Td>}
            <Table.Td>
              <Link
                to={"/tide-graph/" + date.date}
                title="Tidal Graph"
                style={{ textDecoration: "none", color: "inherit" }}
              >
                <Badge size="sm" variant="outline" color="gray" ml="sm">
                  Graph <IconChartHistogram size={10} />
                </Badge>
              </Link>
            </Table.Td>
          </Table.Tr>
        ))}
      </Table.Tbody>
    </Table>
  );
}
