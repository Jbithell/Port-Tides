import { Badge, Table, Text } from "@mantine/core";
import React from "react";
import { DateTime } from "luxon";
import { TidesJson_ScheduleObject } from "../../types";
import { IconSunrise, IconSunset } from "@tabler/icons-react";

export function TideTable({ data }: { data: TidesJson_ScheduleObject[] }) {
  return (
    <Table highlightOnHover stickyHeader stickyHeaderOffset={60}>
      <Table.Thead>
        <Table.Tr>
          <Table.Th>Date</Table.Th>
          <Table.Th>Sunrise</Table.Th>
          <Table.Th>High Tide</Table.Th>
          <Table.Th>Height</Table.Th>
          <Table.Th>High Tide</Table.Th>
          <Table.Th>Height</Table.Th>
          <Table.Th>Sunset</Table.Th>
        </Table.Tr>
      </Table.Thead>
      <Table.Tbody>
        {data.map((date: TidesJson_ScheduleObject, index: React.Key) => (
          <Table.Tr key={index}>
            <Table.Td>
              <Text>
                {DateTime.fromSQL(date.date).toLocaleString({
                  weekday: "long",
                  day: "2-digit",
                })}
                {DateTime.fromSQL(date.date).toJSDate().setHours(0, 0, 0, 0) ==
                new Date().setHours(0, 0, 0, 0) ? (
                  <Badge ml="sm">Today</Badge>
                ) : null}
              </Text>
            </Table.Td>
            <Table.Td>
              <Text>
                {date.sunrise} <IconSunrise size={14} />
              </Text>
            </Table.Td>
            {date.groups.map((tide) => (
              <>
                <Table.Td>
                  <Text>
                    {DateTime.fromSQL(
                      date.date + " " + tide.time
                    ).toLocaleString(DateTime.TIME_SIMPLE)}
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
            <Table.Td>
              <Text>
                {date.sunset} <IconSunset size={14} />
              </Text>
            </Table.Td>
          </Table.Tr>
        ))}
      </Table.Tbody>
    </Table>
  );
}
