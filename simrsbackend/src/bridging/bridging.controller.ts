import { Body, Controller, Get, Param, Patch, Post } from '@nestjs/common';
import { BridgingService, SepTask } from './bridging.service';

@Controller('bridging')
export class BridgingController {
  constructor(private readonly bridgingService: BridgingService) {}

  @Post('sep/:registrasiId')
  requestSepSync(@Param('registrasiId') registrasiId: string): SepTask {
    return this.bridgingService.requestSync(registrasiId);
  }

  @Patch('sep/:taskId/state')
  updateSepState(@Param('taskId') taskId: string, @Body('state') state: SepTask['state']): SepTask | undefined {
    return this.bridgingService.updateTask(taskId, state);
  }

  @Get('sep/tasks')
  getSepTasks(): SepTask[] {
    return this.bridgingService.getTasks();
  }
}
