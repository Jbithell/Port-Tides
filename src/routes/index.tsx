import { getHomepageTides } from "@/readTideTimes";
import {
  Button,
  Card,
  Center,
  Group,
  SimpleGrid,
  Stack,
  Text,
  Title,
  useMatches
} from "@mantine/core";
import {
  IconArrowRight,
  IconCalendar,
  IconChartHistogram,
  IconDownload,
  IconTable,
} from "@tabler/icons-react";
import { createFileRoute, Link } from "@tanstack/react-router";
import { DateTime } from "luxon";
import * as React from "react";
import Layout from "../components/navigation/Layout";

export const Route = createFileRoute('/')({
  component: App,
  loader: async () => {
    return getHomepageTides({ data: { daysToDisplay: 10 } }) // Fetch the maximum needed (10) so it's available for all screen sizes
  },
})

function App() {
  const { homepageTides, today, homepageFiles } = Route.useLoaderData()
  const daysToDisplay = useMatches({ base: 3, sm: 6, md: 8, lg: 10, xl: 10 }) as number;
  const tidesToDisplay = homepageTides.slice(0, daysToDisplay);

  return (
    <Layout>
      <Center>
        <Stack align="center" gap={"sm"}>
          <Title order={1} size={"h1"} mb={0}>
            Porthmadog Tide Times
          </Title>
          <Text fw={200}>North Wales, United Kingdom</Text>
        </Stack>
      </Center>
      <Group justify="space-between" mb="sm" mt="sm">
        <Title order={2} size={"h3"}>
          High Tide Times this week
        </Title>
        <Group justify="flex-end">
          <Link
            to={
              "/tide-graph/" + DateTime.fromJSDate(today).toFormat("yyyy-LL-dd")
            }
            style={{ textDecoration: "none" }}
          >
            <Button
              rightSection={<IconChartHistogram size={14} />}
              variant="light"
              visibleFrom="sm"
            >
              Today's Graph
            </Button>
          </Link>
          <Link
            to={"tide-tables/" + DateTime.fromJSDate(today).toFormat("yyyy/LL")}
          >
            <Button
              leftSection={<IconTable size={14} />}
              variant="light"
              visibleFrom="sm"
            >
              {DateTime.fromJSDate(today).toFormat("MMMM")}{" "}
              Tide Table
            </Button>
          </Link>
        </Group>
      </Group>
      <SimpleGrid cols={{ base: 1, sm: 3, md: 4, lg: 5, xl: 5 }}>
        {tidesToDisplay.map((element, index: React.Key) => (
          <Card shadow="xs" padding={"xs"} key={index}>
            <Text size="xl" fw={500} mb={"xs"}>
              {DateTime.fromSQL(element.date).toFormat("cccc dd MMMM")}
            </Text>
            {element.groups.map((tide) => (
              <Group justify="start" mt={0} mb={0} key={tide.time}>
                <Text size="lg" fw={500}>
                  {DateTime.fromSQL(
                    element.date + " " + tide.time
                  ).toFormat("HH:mm")}
                </Text>
                <Text size="lg" fw={200}>
                  {tide.height}m
                </Text>
              </Group>
            ))}
          </Card>
        ))}
        <Link
          to={
            "/tide-graph/" + DateTime.fromJSDate(today).toFormat("yyyy-LL-dd")
          }
          style={{ textDecoration: "none" }}
        >
          <Card shadow="xs" padding={"xs"} hiddenFrom="sm">
            <Group justify="space-between">
              <Text size="xl" fw={500}>
                Today's Graph
              </Text>
              <IconChartHistogram />
            </Group>
          </Card>
        </Link>
        <Link
          to={"/tide-tables/" + DateTime.fromJSDate(today).toFormat("yyyy/LL")}
          style={{ textDecoration: "none" }}
        >
          <Card shadow="xs" padding={"xs"} hiddenFrom="sm">
            <Group justify="space-between">
              <Text size="xl" fw={500}>
                {DateTime.fromJSDate(today).toFormat("MMMM")}{" "}
                Tide Table
              </Text>
              <IconArrowRight />
            </Group>
          </Card>
        </Link>
      </SimpleGrid>
      <Group justify="space-between" mb="sm" mt="sm">
        <Title order={2} size={"h3"}>
          Monthly Tide Tables
        </Title>
        <Group justify="flex-end">
          <Link to={"/ical"}>
            <Button rightSection={<IconCalendar size={14} />} variant="light">
              Add to Calendar
            </Button>
          </Link>
          <Link to={"/tide-tables"}>
            <Button rightSection={<IconArrowRight size={14} />} variant="light">
              View All
            </Button>
          </Link>
        </Group>
      </Group>
      <SimpleGrid cols={{ base: 1, sm: 3, md: 4 }}>
        {homepageFiles.map((month, index) => (
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
    </Layout>
  );
};