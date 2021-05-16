import * as React from "react";
import Header from "../components/Header.js";
import Tides from "../components/Tides.js";
import PDFs from "../components/PDFs.js";
import Footer from "../components/Footer.js";

const IndexPage = () => {
  return (
    <>
      <Header lang="en" />
      <Tides lang="en" />
      <PDFs lang="en" />
      <Footer lang="en" />
    </>
  );
};

export default IndexPage;
