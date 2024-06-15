import { Accordion, Button, Code, CopyButton, Text } from "@mantine/core";
import { IconCopy, IconCopyCheck, IconHome } from "@tabler/icons-react";
import type { HeadFC, PageProps } from "gatsby";
import { Link } from "gatsby";
import * as React from "react";
import TidalData from "../../data/tides.json";
import { SEO } from "../components/SEO";
import Layout from "../components/navigation/Layout";
import { TideTablesMonthList } from "../components/tideTables/TideTablesMonthList";
import { TidesJson_PDFObject } from "../types";
import { useLocation } from "@reach/router";

const Page: React.FC<PageProps> = () => {
  const { origin } = useLocation();
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
            <Text>
              <ol>
                <li>
                  Copy the URL <Code>{iCalUrl}</Code>
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button onClick={copy}>
                        {copied ? <IconCopyCheck /> : <IconCopy />}
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
                  Copy the URL <Code>{iCalUrl}</Code>
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button onClick={copy}>
                        {copied ? <IconCopyCheck /> : <IconCopy />}
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
                  Copy the URL <Code>{iCalUrl}</Code>
                  <CopyButton value={iCalUrl}>
                    {({ copied, copy }) => (
                      <Button onClick={copy}>
                        {copied ? <IconCopyCheck /> : <IconCopy />}
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
export default Page;

export const Head: HeadFC = () => <SEO title="Tide Times in your calendar" />;
