import { Container, Group, Text } from '@mantine/core';
import * as classes from './Footer.module.css';
import React from 'react';
import { Link } from 'gatsby';
import { useBuildDate } from '../../hooks/use-build-date';

export function Footer() {
  const buildYear = useBuildDate()

  return (
    <Container size="xl" className={classes.inner}>
      <Text>Times are GMT/BST. No warranty is provided for the accuracy of data displayed. Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the UKHO licensing department.</Text>
      <Text>&copy;2014-{buildYear} James Bithell</Text>
    </Container>
  );
}