import {
  AppShell,
  Box,
  Center,
  Container,
  Group,
  Title,
  useMatches,
} from "@mantine/core";
import React from "react";
import { Footer } from "./Footer";

export default function Layout({
  children,
  title,
  headerButtons,
}: {
  children: React.ReactNode;
  headerButtons?: React.ReactNode;
  title?: string;
}) {
  const showHeader = useMatches({
    base: false,
    sm: true,
  });
  return (
    <AppShell
      header={{ height: showHeader && headerButtons && title ? 60 : 0 }}
      footer={{ height: 60 }}
      padding="md"
    >
      {showHeader && headerButtons && title ? (
        <AppShell.Header>
          <Container size="xl">
            <Group justify="space-between" align="center" mt="xs">
              <Title size={"h2"} order={1}>
                {title}
              </Title>
              <Box>
                <Group justify="flex-end">{headerButtons}</Group>
              </Box>
            </Group>
          </Container>
        </AppShell.Header>
      ) : null}
      <AppShell.Main>
        {!showHeader && headerButtons && title ? (
          <>
            <Center>
              <Title order={1} size={"h2"} hiddenFrom="sm">
                {title}
              </Title>
            </Center>
            <Group
              justify="space-between"
              hiddenFrom="sm"
              align="center"
              mt="xs"
              mb="mb"
            >
              {headerButtons}
            </Group>
          </>
        ) : null}
        <Container size="xl">{children}</Container>
      </AppShell.Main>
      <AppShell.Footer>
        <Footer />
      </AppShell.Footer>
    </AppShell>
  );
}
