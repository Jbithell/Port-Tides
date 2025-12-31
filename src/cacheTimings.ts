import { createServerFn } from '@tanstack/react-start';
import { DateTime } from 'luxon';

export const secondsLeftInDay = createServerFn({ method: 'GET' }).handler(() => {
  const now = DateTime.now().setZone('Europe/London')
  const expiry = Math.floor(now.endOf('day').diff(now, 'seconds').seconds)
  return expiry
})
export const etagForDay = createServerFn({ method: 'GET' }).handler(() => {
  const now = DateTime.now().setZone('Europe/London')
  return `${now.toFormat('yyyy-MM-dd')}`
})
export const secondsLeftIMonth = createServerFn({ method: 'GET' }).handler(() => {
  const now = DateTime.now().setZone('Europe/London')
  const expiry = Math.floor(now.endOf('month').diff(now, 'seconds').seconds)
  return expiry
})
export const etagForMonth = createServerFn({ method: 'GET' }).handler(() => {
  const now = DateTime.now().setZone('Europe/London')
  return `${now.toFormat('yyyy-MM')}`
})