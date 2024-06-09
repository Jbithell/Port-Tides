import * as React from "react";
import { Link, HeadFC, PageProps } from "gatsby";
import { Title, Text, Button, Container, Group } from "@mantine/core";
import Layout from "../components/navigation/Layout";
import * as classes from "./404.module.css";
import { SEO } from "../components/SEO";

const Page: React.FC<PageProps> = () => {
  return (
    <Layout>
      <Container className={classes.root}>
        <div className={classes.label}>404</div>
        <Title className={classes.title}>Page not found</Title>
        <Text c="dimmed" size="lg" ta="center" className={classes.description}>
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
    </Layout>
  );
};

export default Page;

export const Head: HeadFC = () => <SEO title="404" />;
