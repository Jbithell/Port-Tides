// src/theme.ts
import { MantineColorsTuple, createTheme } from '@mantine/core';


const myColor: MantineColorsTuple = [
  "#ffe9f0",
  "#ffd0dd",
  "#faa0b8",
  "#f66d90",
  "#f2426f",
  "#f1275a",
  "#f1184f",
  "#d70841",
  "#c00038",
  "#a9002f",
];

export const theme = createTheme({
  primaryColor: "pink",
  colors: {
    pink: myColor,
  },
  primaryShade: 3,
});