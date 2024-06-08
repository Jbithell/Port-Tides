import { AppShell, Container } from "@mantine/core"
import React from "react"
import { Header } from "./Header"
import { Footer } from "./Footer"
import { useDisclosure } from "@mantine/hooks";
import { MobileNavbar } from "./MobileNavbar";

export default function Layout({ children }: { children: React.ReactNode }) {
  const [menuOpened, { toggle: menuToggle }] = useDisclosure(false);
  return (
    <AppShell
      header={{ height: 60 }}
      navbar={{
        width: 300,
        breakpoint: 'sm',
        collapsed: { mobile: !menuOpened, desktop: true },
      }}
      padding="md"
    >
      <AppShell.Header><Header menuOpened={menuOpened} menuToggle={menuToggle} /></AppShell.Header>
      <AppShell.Navbar p="md"><MobileNavbar /></AppShell.Navbar>
      <AppShell.Main>
        <Container size="xl">
          {children}
        </Container>
      </AppShell.Main>
      <AppShell.Footer><Footer /></AppShell.Footer>
    </AppShell>
  )
}