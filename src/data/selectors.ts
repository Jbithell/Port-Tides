import { createSelector } from 'reselect';
import { Schedule,Tide } from '../models/Schedule';
import { PDF } from '../models/PDF';
import { AppState } from './state';

export const getSchedule = (state: AppState) => {
  return state.data.schedule
};

export const getPDFs = (state: AppState) => {
  return state.data.pdfs;
}

const getIdParam = (_state: AppState, props: any) => {
  return props.match.params['id'];
}
