import { combineReducers } from './combineReducers';
import { sessionsReducer } from './sessions/sessions.reducer';
import { userReducer } from './user/user.reducer';

export const initialState: AppState = {
  data: {
    schedule: [],
    tide: [],
    pdfs: [],
    loading: false
  },
  user: {
    hasSeenTutorial: false,
    darkMode: false,
    loading: false
  }
};

export const reducers = combineReducers({
  data: sessionsReducer,
  user: userReducer
});

export type AppState = ReturnType<typeof reducers>;
