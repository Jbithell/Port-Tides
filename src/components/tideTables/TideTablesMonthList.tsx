import { Card, Group, SimpleGrid, Text } from "@mantine/core";
import {
  IconDownload
} from "@tabler/icons-react";
import { Link } from "@tanstack/react-router";
import React from "react";
import { TidesJson_PDFObject } from "../../types";

export function TideTablesMonthList({
  files,
}: {
  files: TidesJson_PDFObject[];
}) {
  return (
    <SimpleGrid cols={{ base: 1, sm: 3, md: 4 }}>
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
              <IconDownload />
            </Group>
          </Card>
        </Link>
      ))}
    </SimpleGrid>
  );
}
