import { LineChart } from "@mantine/charts";
import { Paper, Text } from "@mantine/core";
import { graphDataGenerator } from "./graphDataGenerator";

interface ChartTooltipProps {
  label: string;
  payload: Record<string, any>[] | undefined;
  highTides: Array<{ timestamp: number; height: number }>;
}

function ChartTooltip({ label, payload, highTides }: ChartTooltipProps) {
  if (!payload) return null;
  const currentTide = highTides.find(
    (tide) => tide.timestamp === Number(label)
  );
  return (
    <Paper px="md" py="sm" withBorder shadow="md" radius="md">
      <Text fw={500} mb={5}>
        {new Date(Number(label) * 1000).toLocaleDateString("en-GB", {
          day: "numeric",
          month: "short",
          year: "numeric",
          hour: "numeric",
          minute: "numeric",
        })}
      </Text>
      {payload.map((item: any) => (
        <Text key={item.name} c={item.color} fz="sm">
          {item.name}: {item.value}m
        </Text>
      ))}
      {currentTide === undefined && (
        <Text c="red" fz="sm">
          Caution: Estimated tide height
        </Text>
      )}
    </Paper>
  );
}

export function TidalGraphComponent({
  highTides,
  startTimestamp,
  endTimestamp,
}: {
  highTides: Array<{ timestamp: number; height: number }>;
  startTimestamp: number;
  endTimestamp: number;
}) {
  const graphData = graphDataGenerator(highTides);
  return (
    <LineChart
      h={800}
      data={graphData.filter(
        (data) =>
          data.date >= startTimestamp &&
          data.date <= endTimestamp &&
          data.Height >= 0
      )}
      gridAxis="none"
      dataKey="date"
      xAxisLabel="Date"
      yAxisLabel="Height"
      yAxisProps={{
        domain: [0, 5.5],
        allowDataOverflow: false,
        interval: "equidistantPreserveStart",
        tickCount: 28,
        type: "number",
      }}
      xAxisProps={{
        tickFormatter: (value: number) =>
          new Date(value * 1000).toLocaleTimeString("en-GB", {
            hour: "numeric",
            hour12: true,
          }),
        padding: { left: 30, right: 30 },
        interval: "equidistantPreserveStart",
        allowDecimals: false,
        domain: [startTimestamp, endTimestamp],
        type: "number",
        ticks: Array.from(Array(25).keys()).map(
          (i) => startTimestamp + i * 60 * 60
        ),
      }}
      tooltipProps={{
        content: ({ label, payload }) => (
          <ChartTooltip label={label} payload={payload} highTides={highTides} />
        ),
      }}
      unit="m"
      connectNulls={false}
      series={[{ name: "Height", color: "indigo.6" }]}
      curveType="natural"
      dotProps={{ r: 0 }}
      strokeWidth={2}
      activeDotProps={{ r: 8, strokeWidth: 1, fill: "#fff" }}
      referenceLines={[
        { y: 5.1, label: "MHWS", color: "red.6" },
        { y: 3.4, label: "MHWN", color: "red.6" },
        //{ y: 1.8, label: "MLWN", color: "red.6" },
        //{ y: 0.3, label: "MLWS", color: "red.6" },
        ...highTides.flatMap((tide) => ({
          x: tide.timestamp,
          label: tide.height + "m",
          color: "gray.6",
        })),
      ]}
    />
  );
}
