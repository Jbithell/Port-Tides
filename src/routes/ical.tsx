import { Accordion, Button, CopyButton, Text } from "@mantine/core";
import { IconCopy, IconCopyCheck, IconHome } from "@tabler/icons-react";
import { createFileRoute, Link } from '@tanstack/react-router';
import Layout from "../components/navigation/Layout";

export const Route = createFileRoute('/ical')({
  component: PostsIndexComponent,
  head: () => ({
    meta: [
      {
        title: 'Tide Times in your Calendar - Porthmadog Tide Times',
      },
      {
        name: 'description',
        content: 'Subscribe to Porthmadog tide times in Google Calendar, Apple Calendar, or Outlook.',
      },
    ],
    links: [
      {
        rel: 'canonical',
        href: `https://port-tides.com/ical`,
      },
    ],
    scripts: [
      {
        type: 'application/ld+json',
        children: JSON.stringify({
          '@context': 'https://schema.org',
          '@type': 'HowTo',
          name: 'How to add Tide Times to your Calendar',
          description: 'A tutorial on how to subscribe to Porthmadog Tide Times in Google Calendar, Apple Calendar, or Outlook using an iCal link.',
          totalTime: 'PT2M',
          tool: [
            {
              '@type': 'HowToTool',
              name: 'Calendar App'
            }
          ],
          step: [
            {
              '@type': 'HowToStep',
              name: 'Copy iCal URL',
              text: 'Copy the dynamic iCal URL provided on the page.'
            },
            {
              '@type': 'HowToStep',
              name: 'Open Calendar Settings',
              text: 'Navigate to the "Add Calendar" or "Subscribe" section in your calendar application (Google, Apple, or Outlook).'
            },
            {
              '@type': 'HowToStep',
              name: 'Subscribe',
              text: 'Paste the URL and confirm the subscription to see tide times in your view.'
            }
          ],
          author: {
            '@type': 'Organization',
            name: 'Porthmadog Tide Times',
          },
          datePublished: new Date().toISOString(),
        }),
      },
    ],
  }),
  headers: () => {
    return {
      'Cache-Control': `public, max-age=604800, s-maxage=31536000`, // Cache for 7 days client side, 1 year CDN side
    }
  },
})

function PostsIndexComponent() {
  const origin = typeof window !== 'undefined' ? window.location.origin : '';
  const iCalUrl = origin + "/porthmadog-tides.ical";
  return (
    <Layout
      title="Tide Times in your Calendar"
      headerButtons={
        <Link to={"/"}>
          <Button leftSection={<IconHome size={14} />} variant="light">
            Homepage
          </Button>
        </Link>
      }
    >
      <Accordion multiple defaultValue={["google", "apple", "outlook"]}>
        <Accordion.Item value="google">
          <Accordion.Control>
            <Text size="xl" fw={500} mb={"xs"}>
              Google Calendar
            </Text>
          </Accordion.Control>
          <Accordion.Panel>
            <Text size="lg">
              <ol>
                <li>
                  Copy the URL {iCalUrl}
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button
                        variant="outline"
                        size="compact-sm"
                        ml="sm"
                        onClick={copy}
                      >
                        {copied ? (
                          <IconCopyCheck size={16} />
                        ) : (
                          <IconCopy size={16} />
                        )}
                      </Button>
                    )}
                  </CopyButton>
                </li>
                <li>
                  <a href="https://calendar.google.com" target="_blank">
                    Open Google Calendar
                  </a>
                  , click the <em>+</em> above <em>My calendars</em> and choose{" "}
                  <em>From URL</em>.
                </li>
                <li>
                  Paste the URL into the field named <em>URL of calendar</em>{" "}
                  that appears and click
                  <em>Add calendar</em>.
                </li>
                <li>
                  After a few seconds, it should appear in your calendar. If it
                  does not, try reloading Google Calendar.
                </li>
              </ol>
            </Text>
          </Accordion.Panel>
        </Accordion.Item>
        <Accordion.Item value="apple">
          <Accordion.Control>
            <Text size="xl" fw={500} mb={"xs"}>
              Apple Calendar
            </Text>
          </Accordion.Control>
          <Accordion.Panel>
            <Text>
              <ol>
                <li>
                  Copy the URL {iCalUrl}
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button
                        variant="outline"
                        size="compact-sm"
                        ml="sm"
                        onClick={copy}
                      >
                        {copied ? (
                          <IconCopyCheck size={16} />
                        ) : (
                          <IconCopy size={16} />
                        )}
                      </Button>
                    )}
                  </CopyButton>
                </li>
                <li>
                  In Apple Calendar, click the <em>File</em> menu and choose{" "}
                  <em>New Calendar Subscription…</em>.
                </li>
                <li>
                  Paste the URL into the dialog that appears and click{" "}
                  <em>Subscribe</em>.
                </li>
                <li>
                  A window with settings of the calendar subscription will
                  appear. Set <em>Auto-refresh</em> to <em>Every hour</em> to
                  keep your calendar up to date and click <em>OK</em>.
                </li>
              </ol>
            </Text>
          </Accordion.Panel>
        </Accordion.Item>
        <Accordion.Item value="outlook">
          <Accordion.Control>
            <Text size="xl" fw={500} mb={"xs"}>
              Outlook
            </Text>
          </Accordion.Control>
          <Accordion.Panel>
            <Text>
              <ol>
                <li>
                  Copy the URL {iCalUrl}
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button
                        variant="outline"
                        size="compact-sm"
                        ml="sm"
                        onClick={copy}
                      >
                        {copied ? (
                          <IconCopyCheck size={16} />
                        ) : (
                          <IconCopy size={16} />
                        )}
                      </Button>
                    )}
                  </CopyButton>
                </li>
                <li>
                  In Outlook, click <em>Open Calendar</em> and choose{" "}
                  <em>From Internet…</em>.
                </li>
                <li>
                  Paste the URL into the Outlook dialog that appears and click{" "}
                  <em>OK</em>.
                </li>
                <li>
                  After a few seconds, Outlook will ask if the internet calendar
                  should be added. Click <em>Yes</em>.
                </li>
              </ol>
            </Text>
          </Accordion.Panel>
        </Accordion.Item>
      </Accordion>
    </Layout>
  );
};