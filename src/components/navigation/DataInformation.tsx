import { Text } from "@mantine/core";
import React from "react";
import { useBuildDate } from "../../hooks/use-build-date";

export function DataInformation() {
  const buildYear = useBuildDate();
  console.log(buildYear);
  return (
    <>
      <Text>
        Times are GMT/BST. Heights shown are heights above chart datum. Low
        water times are not provided due to seasonal variations and river flows.
      </Text>
      <Text>
        No warranty is provided for the accuracy of data displayed. Tidal Data
        is &copy;Crown Copyright. Reproduced by permission of the Controller of
        Her Majesty's Stationery Office and the UK Hydrographic Office
        (www.ukho.gov.uk). No tidal data may be reproduced without the expressed
        permission of the UKHO licensing department.
      </Text>
    </>
  );
}
