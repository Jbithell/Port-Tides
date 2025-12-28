import { createServerFn } from '@tanstack/react-start';
//import { readFileSync } from "node:fs";
import tidalDataFromFile from './data/tides.json';
import type { TidesJson_TopLevel } from './types';

//const TIDES_FILE = 'data/tides.json'

export const getTides = createServerFn({ method: 'GET' }).handler(async () => {
  //const tides = readFileSync(TIDES_FILE, "utf8");
  //return JSON.parse(tides) as TidesJson_TopLevel
  return tidalDataFromFile as TidesJson_TopLevel
})