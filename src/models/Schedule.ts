export interface Schedule {
  date: string;
  groups: Tide[];
}
export interface Tide {
  time: string;
  height: string;
}
