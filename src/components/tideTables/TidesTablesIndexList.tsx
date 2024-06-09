import React from "react";
import { TidesJson_PDFObject } from "../../types";
import TidalData from "../../../data/tides.json";
import { TideTablesMonthList } from "./TideTablesMonthList";

export function TideTablesIndexList() {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);
  const files = TidalData.pdfs.filter((pdf: TidesJson_PDFObject) => {
    let date = new Date(pdf.date);
    return date < nextYear && date >= month;
  });
  return <TideTablesMonthList files={files} />;
}
