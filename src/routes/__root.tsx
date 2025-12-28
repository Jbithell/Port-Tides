import { MantineProvider, createTheme } from '@mantine/core';
import '@mantine/core/styles.css';
import { TanStackDevtools } from '@tanstack/react-devtools';
import { HeadContent, Scripts, createRootRoute, createRoute, redirect } from '@tanstack/react-router';
import { TanStackRouterDevtoolsPanel } from '@tanstack/react-router-devtools';

export const theme = createTheme({});
export const Route = createRootRoute({
  head: () => ({
    meta: [
      {
        charSet: 'utf-8',
      },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1',
      },
      {
        title: 'Porthmadog Tide Times',
      },
      {
        name: 'description',
        content: "Free tidal predictions for the seaside town of Porthmadog and its beautiful estuary. The best place to get tide times for Porthmadog, Borth-y-gest, Morfa Bychan and Black rock sands",
      }
    ],
    links: [
      {
        rel: 'icon',
        href: '/favicon.ico',
      },
    ],
  }),
  shellComponent: RootDocument,
})
function RootDocument({ children }: { children: React.ReactNode }) {
  return (
    <MantineProvider theme={theme}>
      <html lang="en">
      <head>
        <HeadContent />
      </head>
      <body>
        {children}
        <TanStackDevtools
          config={{
            position: 'bottom-right',
          }}
          plugins={[
            {
              name: 'Tanstack Dev Tools',
              render: <TanStackRouterDevtoolsPanel />,
            },
          ]}
        />
        <Scripts />
      </body>
      </html>
    </MantineProvider>
  )
}
export const historicalTablesRedirect = createRoute({
  getParentRoute: () => Route,
  path: '/historical-tables', // Catches all unmatched paths
  beforeLoad: () => {
    // Redirect all unmatched routes to the homepage or a 404 page
    return redirect({ to: '/tide-tables', replace: true });
  },
});