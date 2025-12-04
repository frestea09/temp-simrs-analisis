import { Injectable } from '@nestjs/common';

export interface SepTask {
  id: string;
  registrasiId: string;
  state: 'requested' | 'in-progress' | 'synced';
  lastSync: Date;
}

@Injectable()
export class BridgingService {
  private readonly tasks: SepTask[] = [];

  requestSync(registrasiId: string): SepTask {
    const task: SepTask = {
      id: `SEP-${registrasiId}-${Date.now()}`,
      registrasiId,
      state: 'requested',
      lastSync: new Date(),
    };
    this.tasks.push(task);
    return task;
  }

  updateTask(taskId: string, state: SepTask['state']): SepTask | undefined {
    const task = this.tasks.find((item) => item.id === taskId);
    if (task) {
      task.state = state;
      task.lastSync = new Date();
    }
    return task;
  }

  getTasks(): SepTask[] {
    return this.tasks;
  }
}
