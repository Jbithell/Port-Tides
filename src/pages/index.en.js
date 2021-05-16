import * as React from "react";
import Layout from "../components/Layout.js";
import Tides from "../components/Tides.js";
import PDFs from "../components/PDFs.js";
const IndexPage = () => {
  return (
    <Layout lang="en">
      <Tides lang="en" />
      <PDFs lang="en" historical={false} />
    </Layout>
  );
};

export default IndexPage;
