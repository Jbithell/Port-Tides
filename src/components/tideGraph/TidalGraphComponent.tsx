import { LineChart } from "@mantine/charts";
import { Paper, Stack, Switch, Text } from "@mantine/core";
import { useLocalStorage } from "@mantine/hooks";
import { DateTime } from "luxon";
import classes from './TidalGraph.module.css';

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
        {DateTime.fromMillis(Number(label) * 1000).toFormat("d MMM yyyy, HH:mm")}
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
const defaultConfig = {
  showSunriseSunset: true,
  showMHWSMHWN: true,
  showMLWNMLWS: false,
  showHighTides: true,
}
export function TidalGraphComponent({
  highTides,
  sunrise,
  sunset,
  startTimestamp,
  endTimestamp,
  graphData,
}: {
  highTides: Array<{ timestamp: number; height: number }>;
  sunrise: number;
  sunset: number;
  startTimestamp: number;
  endTimestamp: number;
  graphData: Array<{ date: number; Height: number }>;
}) {
  const [config, setLocalStorageConfig] = useLocalStorage({
    key: 'tidal-graph-config',
    defaultValue: defaultConfig,
  });
  const setConfig = (update: Partial<typeof defaultConfig> | ((current: typeof defaultConfig) => Partial<typeof defaultConfig>)) => {
    setLocalStorageConfig((prev) => ({
      ...prev,
      ...(typeof update === 'function' ? update(prev) : update),
    }));
  };
  return (
    <>
      <LineChart
        h={800}
        className={classes.root}
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
            DateTime.fromMillis(value * 1000).toFormat("h a"),
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
          ...(config.showMHWSMHWN ? [
            { y: 5.1, label: "MHWS", color: "red.6" },
            { y: 3.4, label: "MHWN", color: "red.6" },
          ] : []),
          ...(config.showMLWNMLWS ? [
            { y: 1.8, label: "MLWN", color: "red.6" },
            { y: 0.3, label: "MLWS", color: "red.6" },
          ] : []),
          ...(config.showHighTides ? highTides.flatMap((tide) => ({
            x: tide.timestamp,
            label: DateTime.fromMillis(tide.timestamp * 1000).toFormat("HH:mm"),
            color: 'var(--hightide-line-color)',
          })) : []),
          ...(config.showSunriseSunset ? [
            { x: sunrise, label: "Sunrise", color: 'var(--sunrisesunset-line-color)' },
            { x: sunset, label: "Sunset", color: 'var(--sunrisesunset-line-color)' }
          ] : []),
        ]}
      />
      <Paper shadow="xl" withBorder p="xs" mb="xl" mt="md">
        <Stack
          align="stretch"
          justify="center"
          gap="md"
        >
          <Switch
            onLabel="SHOW" offLabel="HIDE"
            checked={config.showSunriseSunset}
            onChange={(event) => setConfig({ showSunriseSunset: event.currentTarget.checked })}
            label="Sunrise/Sunset Times"
            size="md"
          />
          <Switch
            onLabel="SHOW" offLabel="HIDE"
            checked={config.showHighTides}
            onChange={(event) => setConfig({ showHighTides: event.currentTarget.checked })}
            label="High Tides"
            size="md"
          />
          <Switch
            onLabel="SHOW" offLabel="HIDE"
            checked={config.showMHWSMHWN}
            onChange={(event) => setConfig({ showMHWSMHWN: event.currentTarget.checked })}
            label="Mean High Water Springs (MHWS) and Mean High Water Neaps (MHWN)"
            size="md"
          />
          <Switch
            onLabel="SHOW" offLabel="HIDE"
            checked={config.showMLWNMLWS}
            onChange={(event) => setConfig({ showMLWNMLWS: event.currentTarget.checked })}
            label="Mean Low Water Neaps (MLWN) and Mean Low Water Springs (MLWS)"
            size="md"
          />
        </Stack>
      </Paper>
    </>
  );
}
