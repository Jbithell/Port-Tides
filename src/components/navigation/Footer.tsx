import { Button, Container, Group, Modal, Text } from "@mantine/core";
import React from "react";
import { Link } from "gatsby";
import { useBuildDate } from "../../hooks/use-build-date";
import { useDisclosure } from "@mantine/hooks";
import { DataInformation } from "./DataInformation";

export function Footer() {
  const buildYear = useBuildDate();
  const [opened, { open, close }] = useDisclosure(false);

  return (
    <>
      <Modal
        opened={opened}
        onClose={close}
        title="Data Information"
        size={"lg"}
      >
        <DataInformation />
      </Modal>

      <Container size="xl">
        <Group justify="space-between" align="center" mt="md">
          <Button size="compact-md" variant="outline" onClick={open}>
            Data information
          </Button>
          <Text>
            &copy;2014-{buildYear}{" "}
            <Link
              to={"https://jbithell.com"}
              style={{ textDecoration: "none", color: "inherit" }}
            >
              James Bithell
            </Link>
          </Text>
        </Group>
      </Container>
    </>
  );
}
