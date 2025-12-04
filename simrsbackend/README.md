# SIMRS Backend (NestJS)

Modernized backend baseline for RSUD Otista SIMRS functionality using NestJS 10.x. This starter provides
modular boundaries for patient management, queueing/triage, complaint intake (SIPEKA), SEP/bridging tasks, and a
schema-driven gateway that automatically exposes CRUD endpoints for every table defined in `rsud_otista.sql`.

## Getting Started

1) Copy `.env.example` to `.env` and adjust database credentials.

```bash
cp .env.example .env
npm install
npm run start:dev
```

The server boots on port `3000` by default with the `api` prefix (e.g. `http://localhost:3000/api/queue`). Use the
same MySQL schema as the legacy app—the backend automatically parses `../rsud_otista.sql` to infer columns and
primary keys for 373 tables.

## Module Overview

- **QueueModule**: handles ticket creation and calling next patients per destination/poli.
- **PatientsModule**: simplified patient registry for MRN + demographic data.
- **ComplaintsModule**: captures SIPEKA-like patient complaints and categorization.
- **BridgingModule**: scaffolds SEP/BPJS synchronization tasks with state tracking.
- **TablesModule**: generic CRUD controller backed by the parsed `rsud_otista.sql` dump and MySQL connection. Every
  table is addressable without writing per-table controllers.

### TablesModule endpoints

- `GET /api/tables` — list all tables with primary key metadata.
- `GET /api/tables/:table` — paginated rows; supports `page`, `limit`, `orderBy`, and `orderDir` (ASC/DESC).
- `GET /api/tables/:table/:id` — fetch by single-column primary key.
- `POST /api/tables/:table/lookup` — fetch by composite/explicit primary key object.
- `POST /api/tables/:table` — create a record; payload is filtered to known columns.
- `PATCH /api/tables/:table/:id` — update by single primary key.
- `PATCH /api/tables/:table` — update by primary key object.
- `DELETE /api/tables/:table/:id` or `DELETE /api/tables/:table` — delete by primary key.

Validation is applied globally with whitelisting and DTO-driven constraints to avoid the unchecked inputs present
in the legacy Laravel implementation. Pagination DTOs offer consistent list responses across modules, while the
tables gateway enforces table existence and column whitelisting before writing to MySQL.

## Next Steps
- Map queue/patient/complaint modules to the corresponding RSUD tables using the shared `DatabaseService` for
  production data instead of in-memory lists.
- Add authentication/authorization guards mapped to the SIMRS roles and user accounts.
- Expand controllers to mirror the full set of RSUD Otista workflows (antrian layar LCD, TV feeds,
  SEP tasks, COVID/disaster triage) by translating the legacy routes in `routes/web.php` and `routes/simrs/*`.
