export interface TidesJson_TopLevel {
  schedule: Array<TidesJson_ScheduleObject>;
  pdfs: Array<TidesJson_PDFObject>;
  /*tides: {
    rawAdjusted: {
      [unixTimestamp: number]: string;
    };
    daysAdjusted: {
      [date: number]: Array<{
        time: string;
        height: string;
      }>;
    };
    monthsAdjusted: {
      [month: number]: {
        [day: string]: Array<{
          time: string;
          height: string;
        }>;
      };
    };
  };*/
}
export interface TidesJson_ScheduleObject {
  date: string;
  groups: Array<{
    time: string;
    height: string;
  }>;
}
export interface TidesJson_PDFObject {
  name: string;
  date: string;
  filename: string;
  htmlfilename: string;
  url: string;
}
