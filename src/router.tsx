import { createRouter, Link } from '@tanstack/react-router'

// Import the generated route tree
import { Button, Container, Group, Text, Title } from '@mantine/core'
import { routeTree } from './routeTree.gen'

// Create a new router instance
export const getRouter = () => {
  const router = createRouter({
    routeTree,
    scrollRestoration: true,
    defaultPreloadStaleTime: 0,
    defaultNotFoundComponent: () => {
    return (
      <Container>
        <Title>404 - Page not found</Title>
        <Text c="dimmed" size="lg" ta="center">
          Unfortunately, the page you requested could not be found. You may have
          mistyped the address, or the page has been moved to another URL.
        </Text>
        <Group justify="center">
          <Link to="/">
            <Button variant="subtle" size="md">
              Take me back to home page
            </Button>
          </Link>
        </Group>
      </Container>
    )
  },
  })

  return router
}
