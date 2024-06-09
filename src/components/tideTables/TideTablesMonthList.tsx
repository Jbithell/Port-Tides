import { Badge, Card, Group, SimpleGrid, Table, Text } from "@mantine/core";
import React from "react";
import { DateTime } from "luxon";
import { TidesJson_PDFObject, TidesJson_ScheduleObject } from "../../types";
import {
  IconArrowRight,
  IconSun,
  IconSunrise,
  IconSunset,
} from "@tabler/icons-react";
import { devNull } from "os";
import { Link } from "gatsby";

export function TideTablesMonthList({ files }: { files: TidesJson_PDFObject[] }) {
  return (
    <SimpleGrid cols={{ base: 1, sm: 3, md: 4, lg: 5, xl: 5 }}>
      {files.map((month: TidesJson_PDFObject, index: React.Key) => (
        <Link
          to={"/tide-tables/" + month.url}
          style={{ textDecoration: "none" }}
          key={index}
        >
          <Card shadow="xs" padding={"xs"} key={index}>
            <Group justify="space-between">
              <Text size="xl" fw={500} mb={"xs"}>
                {month.name}
              </Text>
              <IconArrowRight />
            </Group>
          </Card>
        </Link>
      ))}
    </SimpleGrid>
  );
}
