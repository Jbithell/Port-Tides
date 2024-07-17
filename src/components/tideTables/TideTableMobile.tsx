import { Badge, Button, Group, Table, Text } from "@mantine/core";
import React from "react";
import { DateTime } from "luxon";
import { TidesJson_ScheduleObject } from "../../types";
import {
  IconChartHistogram,
  IconSunrise,
  IconSunset,
} from "@tabler/icons-react";
import { Link } from "gatsby";

export function TideTableMobile({
  data,
}: {
  data: TidesJson_ScheduleObject[];
}) {
  return (
    <Table>
      <Table.Tbody>
        {data.map((date: TidesJson_ScheduleObject, index: React.Key) => (
          <Table.Tr key={index}>
            <Table.Td style={{ textAlign: "right", verticalAlign: "top" }}>
              <Text>
                {DateTime.fromSQL(date.date).toLocaleString({
                  weekday: "long",
                  day: "2-digit",
                })}
                {DateTime.fromSQL(date.date).toJSDate().setHours(0, 0, 0, 0) ==
                new Date().setHours(0, 0, 0, 0) ? (
                  <>
                    <br />
                    <Badge>Today</Badge>
                  </>
                ) : null}
              </Text>
              <Link
                to={"/tide-graph/" + date.date}
                title="Tidal Graph"
                style={{ textDecoration: "none", color: "inherit" }}
              >
                <Badge size="sm" variant="outline" color="gray">
                  Graph <IconChartHistogram size={10} />
                </Badge>
              </Link>
            </Table.Td>
            <Table.Td>
              <Group justify="start" mt={0} mb={0}>
                <Text fw={300}>{date.sunrise}</Text>
                <Text fw={200}>
                  Sunrise <IconSunrise size={14} />
                </Text>
              </Group>
              {date.groups.map((tide) => (
                <Group justify="start" mt={0} mb={0}>
                  <Text fw={600}>
                    {DateTime.fromSQL(
                      date.date + " " + tide.time
                    ).toLocaleString(DateTime.TIME_SIMPLE)}
                  </Text>
                  <Text fw={200}>{tide.height}m</Text>
                </Group>
              ))}

              <Group justify="start" mt={0} mb={0}>
                <Text fw={300}>{date.sunset}</Text>
                <Text fw={200}>
                  Sunset <IconSunset size={14} />
                </Text>
              </Group>
            </Table.Td>
          </Table.Tr>
        ))}
      </Table.Tbody>
    </Table>
  );
}
