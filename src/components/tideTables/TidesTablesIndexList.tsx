import { TidesJson_TopLevel } from "@/types";
import { TideTablesMonthList } from "./TideTablesMonthList";

export function TideTablesIndexList({ tidalData }: { tidalData: TidesJson_TopLevel }) {
  const month = new Date();
  month.setHours(0, 0, 0, 0);
  month.setDate(1);
  const nextYear = new Date(month);
  nextYear.setFullYear(month.getFullYear() + 1);
  const files = tidalData.pdfs.filter((pdf) => {
    let date = new Date(pdf.date);
    return date < nextYear && date >= month;
  });
  return <TideTablesMonthList files={files} />;
}
