import { Button, Container, Group, Modal, Text } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { DataInformation } from "./DataInformation";

export function Footer() {
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
            &copy;2014-{new Date().getFullYear()}{" "}
            <a
              href={"https://jbithell.com"}
              style={{ textDecoration: "none", color: "inherit" }}
            >
              James Bithell
            </a>
          </Text>
        </Group>
      </Container>
    </>
  );
}
