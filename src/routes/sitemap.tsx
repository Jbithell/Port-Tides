import { createFileRoute, Link } from '@tanstack/react-router';
import { getSitemapTides } from "../readTideTimes";

/**
 * This page is a long list of all the pages on the site, which is used to crawl the prerender pages to ensure all the tide times are prerendered.
 */

export const Route = createFileRoute('/sitemap')({
  component: Page,
  loader: async () => {
    const tidalData = await getSitemapTides();
    return tidalData;
  },
  head: () => ({
    links: [
      {
        rel: 'canonical',
        href: `https://port-tides.com/sitemap`,
      },
    ],
  }),
})
function Page() {
  const tidalData = Route.useLoaderData();
  if (!tidalData) return null;
  return (
    <ul>
      <li>ICal: <Link to="/ical">ICal</Link></li>
      <li>Tide Tables: <Link to="/tide-tables">Tide Tables</Link></li>
      {tidalData.pdfs.map((pdf) => {
        return (
          <li key={pdf.date}>Tide Table for <Link to="/tide-tables/$" params={{ _splat: pdf.url }}>
            {pdf.date}
          </Link></li>
        );
      })}
      {tidalData.schedule.map((schedule) => {
        return (
          <li key={schedule.date}>Tidal Graph for <Link to="/tide-graph/$date" params={{ date: schedule.date }}>
            {schedule.date}
          </Link></li>
        );
      })}
    </ul>
  );
};