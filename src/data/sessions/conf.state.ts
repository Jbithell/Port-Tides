import { PDF } from '../../models/PDF';
import { Schedule, Tide } from '../../models/Schedule';
export interface ConfState {
  schedule: Schedule[];
  tide: Tide[];
  pdfs: PDF[];
  loading?: boolean;
}
