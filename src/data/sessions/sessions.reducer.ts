import { SessionsActions } from './sessions.actions';
import { ConfState } from './conf.state';

export const sessionsReducer = (state: ConfState, action: SessionsActions): ConfState => {
  switch (action.type) {
    case 'set-conf-loading': {
      return { ...state, loading: action.isLoading };
    }
    case 'set-conf-data': {
      return { ...state, ...action.data };
    }
  }
}
