import * as React from "react";
import Layout from "../components/Layout.js";
import PDFs from "../components/PDFs.js";
const HistoricalTablesPage = () => {
  return (
    <Layout lang="cy">
      <PDFs lang="cy" historical={true} />
    </Layout>
  );
};

export default HistoricalTablesPage;
